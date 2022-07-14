<?php
namespace App\Controller;

use App\Entity\Vote;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\DBAL\Connection;

class YetinderVoteController extends AbstractController
{
    /**
     * @Route("/vote", name="app_vote")
     * @Route("/vote/{yeti_id}", name="app_vote_id")
     */

    public function vote(int $yeti_id = null, Request $request, Connection $connection, SessionInterface $session): Response
    {

        //asking for email to identify user
        $user = new User();
        $form_email = $this->createFormBuilder($user, array('allow_extra_fields' =>true))
            ->add('email', TextType::class)
            ->add('save', SubmitType::class, ['label' => 'Submit'])
            ->getForm();

        $form_email->handleRequest($request);
        if ($form_email->isSubmitted() && $form_email->isValid() && $form_email->get('save')->isClicked()) {
            $user = $form_email->getData();
            $user_email = $user->getEmail();
            $session->set('user_email', $user_email);
        }

        if ($session->get('user_email')) {
            $user_email = $session->get('user_email');
        }
        
        if (isset($user_email)) {
            if (!(isset($yeti_id))) {

                //select Yeti with minimal rating, that wasn't previously shown to this user
                $queryBuilder = $connection->createQueryBuilder();
                $queryBuilder
                    ->select('id', 'name', 'height', 'weight', 'address', 'rating', 'photo')
                    ->from('Yetis', 'y')
                    ->where('id not in (SELECT Yetis.id FROM Yetis inner join Rating 
                            on Yetis.id = Rating.yeti_id
                            where user = ?)')
                    ->setParameter(0, $user_email)
                    ->orderBy('rating', 'ASC')
                    ->setMaxResults(1);
            }

            //if it's voting for one Yeti page like ../vote/{yeti_id}
            else {
                $vote_for_one = true;
                $queryBuilder = $connection->createQueryBuilder();
                $queryBuilder
                    ->select('name', 'height', 'weight', 'address', 'rating', 'photo')
                    ->from('Yetis', 'y')
                    ->where('id = ?')
                    ->andWhere('id not in (SELECT Yetis.id FROM Yetis inner join Rating 
                            on Yetis.id = Rating.yeti_id
                            where user = ?)')
                    ->setParameter(0, $yeti_id)
                    ->setParameter(1, $user_email)
                    ->setMaxResults(1);
            }

            $res = $queryBuilder->execute();
            $rows = $res->fetchAllAssociative();
            $rows_num = count($rows);

            if ($rows_num > 0) {
                $sql_test="";

                //showing his/her card and two buttons
                if (!(isset($yeti_id))) {
                    $yeti_id = $rows[0]['id'];
                }
                $yeti_rating = $rows[0]['rating'];
                $yeti_name = $rows[0]['name'];
                $yeti_height = $rows[0]['height'];
                $yeti_weight = $rows[0]['weight'];
                $yeti_address = $rows[0]['address'];
                $yeti_photo = $rows[0]['photo'];

                $vote = new Vote();
                $vote->setYeti_id($yeti_id);
                $vote->setUser($user_email);

                $form = $this->createFormBuilder($vote, array('allow_extra_fields' =>true))
                ->add('dislike', SubmitType::class, ['label' => '-1', 'attr' => ['value' => 'dislike']])
                ->add('skip', SubmitType::class, ['label' => '0', 'attr' => ['value' => 'skip']])
                ->add('like', SubmitType::class, ['label' => '+1', 'attr' => ['value' => 'like']])
                ->getForm();

                //processing results, writing to DB
                $form->handleRequest($request);
                if ($form->isSubmitted() && $form->isValid() && ($form->get('like')->isClicked() || $form->get('dislike')->isClicked() || $form->get('skip')->isClicked())) {

                    if ($form->get('like')->isClicked()) {
                        $vote->setVote(1);
                        $yeti_rating++;
                    }
                    else if ($form->get('dislike')->isClicked()) {
                        $vote->setVote(-1);
                        $yeti_rating--;
                    }
                    else if ($form->get('skip')->isClicked()) {
                        $vote->setVote(0);
                    }
                    $today = new \DateTime('today');
                    $today_sql = date("Y-m-d H:i:s"); 
                    $vote->setDate($today);
                    $vote_value = $vote->getVote();

                    $queryBuilder_vote = $connection->createQueryBuilder();
                    $queryBuilder_vote
                        ->insert('Rating')
                        ->setValue('yeti_id', '?')
                        ->setValue('user', '?')
                        ->setValue('vote', '?')
                        ->setValue('date', '?')
                        ->setParameter(0, $yeti_id)
                        ->setParameter(1, $user_email)
                        ->setParameter(2, $vote_value)
                        ->setParameter(3, $today_sql);
                    $res_insvote = $queryBuilder_vote->execute();

                    if ($vote_value != 0) {

                        $queryBuilder_updrating = $connection->createQueryBuilder();
                        $queryBuilder_updrating
                            ->update('Yetis', 'y')
                            ->set('y.rating', '?')
                            ->where('y.id = ?')
                            ->setParameter(0, $yeti_rating)
                            ->setParameter(1, $yeti_id);

                        $res_updrating = $queryBuilder_updrating->execute();

                    }

                    //extract new data for rendering new Yeti voting form
                    if (!(isset($vote_for_one))) {

                        $queryBuilder_next = $connection->createQueryBuilder();
                        $queryBuilder_next
                            ->select('id', 'name', 'height', 'weight', 'address', 'rating', 'photo')
                            ->from('Yetis')
                            ->where('id not in (SELECT Yetis.id FROM Yetis inner join Rating 
                            on Yetis.id = Rating.yeti_id
                            where user = ?)')
                            ->setParameter(0, $user_email)
                            ->orderBy('rating', 'ASC')
                            ->setMaxResults(1);

                        $res = $queryBuilder_next->execute();
                        $rows = $res->fetchAllAssociative();
                        $rows_num = count($rows);

                        if ($rows_num > 0) {
                            $yeti_id = $rows[0]['id'];
                            $yeti_name = $rows[0]['name'];
                            $yeti_height = $rows[0]['height'];
                            $yeti_weight = $rows[0]['weight'];
                            $yeti_address = $rows[0]['address'];
                            $yeti_rating = $rows[0]['rating'];
                            $yeti_photo = $rows[0]['photo'];
                        }
                        else {
                            $this->addFlash(
                                'notice',
                                'You saw everyone, so you can see Statistics:)'
                            );
                            return $this->redirectToRoute('app_main'); 
                        }
                    }

                    else {
                        $this->addFlash(
                            'notice',
                            'Thanks for your vote:)'
                        );
                        return $this->redirectToRoute('app_main');
                    }
                }


                $photo_dir = $this->getParameter('photos_directory_url');
                return $this->renderForm('yeti/vote.html.twig', [
                    'form' => $form, 'yeti_name' => $yeti_name, 'yeti_height' => $yeti_height, 'yeti_weight' => $yeti_weight, 'yeti_address' => $yeti_address, 'yeti_photo' => $photo_dir.$yeti_photo
                ]);

            }
            else {
                $this->addFlash(
                    'notice',
                    'You saw everyone, so you can see Statistics:)'
                );
                return $this->redirectToRoute('app_main'); 
            }
        }

        return $this->renderForm('yeti/login.html.twig', [
            'form' => $form_email
        ]); 

    }
} 
?>