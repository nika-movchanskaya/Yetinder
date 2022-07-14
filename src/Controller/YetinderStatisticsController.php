<?php
namespace App\Controller;

//use App\Entity\Vote;
//use App\Entity\User;
use App\Entity\Period;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
//use Symfony\Component\Form\Extension\Core\Type\TextType;
//use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\DBAL\Connection;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;

class YetinderStatisticsController extends AbstractController
{
    /**
     * @Route("/stat/{yeti_id}", name="app_stat")
     */

    public function stat(int $yeti_id, ChartBuilderInterface $chartBuilder, Request $request, Connection $connection, SessionInterface $session): Response
    {

        //просуммируем рейтинг до старт дэйт - начальный рейтинг
        //считаем изменениеи рейтинга по дням, которые есть в таблице рейтинга

        //Set date period
        $period = new Period();
        if (!(($session->get('month')) && ($session->get('year')))) {
            $month = date('m');
            $year = date('Y');
            $period->setMonth($month);
            $period->setYear($year);
        }

        $form = $this->createFormBuilder($period, array('allow_extra_fields' =>true))
            ->add('month', ChoiceType::class, [
                'placeholder' => 'month',
                'label' => false,
                'required' => true,
                'choices' => [
                    'January' => 1,
                    'February' => 2,
                    'March' => 3,
                    'April' => 4,
                    'May' => 5,
                    'June' => 6,
                    'July' => 7,
                    'August' => 8,
                    'September' => 9,
                    'October' => 10,
                    'November' => 11,
                    'December' => 12,
                ],
            ])
            ->add('year', ChoiceType::class, [
                'placeholder' => 'year',
                'label' => false,
                'required' => true,
                'choices' => [
                    '2020' => 2020,
                    '2021' => 2021,
                    '2022' => 2022,
                ],
            ])
            ->add('save', SubmitType::class, ['label' => 'OK'])
            ->getForm();

        $form->handleRequest($request);

        //if period was set by form
        if ($form->isSubmitted() && $form->isValid()) {
            $period = $form->getData();
            $month = $period->getMonth();
            $year = $period->getYear();
        }

        $start_date = $year.'-'.$month.'-01';
        $next_month = $month+1;
        $end_date = $year.'-'.$next_month.'-01';
        $session->set('start_date', $start_date);
        $session->set('end_date', $end_date);

        //Calculating rating for our Yeti before this period
        //$sql_prev = 'select Yetis.id, name, sum(Rating.vote) as rating_prev
        //from Yetis inner join Rating on Yetis.id = Rating.yeti_id
        //where Yetis.id = '.$yeti_id.'
        //and date < "'.$start_date.'"'; 

        $queryBuilder = $connection->createQueryBuilder();
        $queryBuilder
            ->select('y.id', 'name', 'sum(r.vote) as rating_prev')
            ->from('Yetis', 'y')
            ->innerJoin('y', 'Rating', 'r', 'y.id = r.yeti_id')
            ->where('y.id = ?')
            ->andWhere('date < ?')
            ->setParameter(0, $yeti_id)
            ->setParameter(1, $start_date);

        $res = $queryBuilder->execute();
        $row_prev = $res->fetchAllAssociative();

        //$res = $connection->fetchAllAssociative($sql_prev);
        $rating_prev = $row_prev[0]['rating_prev'];
        $yeti_name = $row_prev[0]['name'];
        if (!isset($rating_prev)) {
            $rating_prev = 0;
        }

        //Calculating ratings for our Yeti in each day of this period 
        //$sql = 'select Yetis.id, name, sum(Rating.vote) as delta, date 
        //from Yetis inner join Rating on Yetis.id = Rating.yeti_id
        //where Yetis.id = '.$yeti_id.'
        //and date >= "'.$start_date.'"
        //and date < "'.$end_date.'"
        //group by date';

        $queryBuilder2 = $connection->createQueryBuilder();
        $queryBuilder2
            ->select('y.id', 'name', 'sum(r.vote) as delta', 'date')
            ->from('Yetis', 'y')
            ->innerJoin('y', 'Rating', 'r', 'y.id = r.yeti_id')
            ->where('y.id = ?')
            ->andWhere('date >= ?')
            ->andWhere('date < ?')
            ->setParameter(0, $yeti_id)
            ->setParameter(1, $start_date)
            ->setParameter(2, $end_date)
            ->groupBy('date');

        $res = $queryBuilder2->execute();
        $rows = $res->fetchAllAssociative();
        $rows_num = count($rows);

        //Creating arrays of dates and values of rating, that we will pass to Chart script
        if ($rows_num > 0) {
            $i = 0;
            while ($i < $rows_num) {
                $dates[$i] = $rows[$i]['date'];
                $rates[$i] = $rating_prev + $rows[$i]['delta'];
                
                $rating_prev = $rates[$i];
                $i++;
            }
        }
        else {
            return $this->render('yeti/stat.html.twig', [
                'form' => $form->createView(), 'dates' => [], 'rates' => [], 'message' => "Sorry, we don't have values for this period, please select another one", 'yeti_name' => $yeti_name
             ]);
        }

        return $this->render('yeti/stat.html.twig', [
            'form' => $form->createView(), 'dates' => $dates, 'rates' => $rates, 'message' => "Please, choose a period for a Statistics", 'yeti_name' => $yeti_name
        ]);

    }
}
?>