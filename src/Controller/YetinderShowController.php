<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\DBAL\Connection;

class YetinderShowController extends AbstractController
{
    /**
     * @Route("/yeti/{yeti_id}", name="app_show")
     */

    public function show(int $yeti_id, Request $request, Connection $connection): Response
    {

        $queryBuilder = $connection->createQueryBuilder();

        $queryBuilder
            ->select('name', 'height', 'weight', 'address', 'rating', 'photo')
            ->from('Yetis')
            ->where('id = ?')
            ->setParameter(0, $yeti_id);

        $res = $queryBuilder->execute();
        $rows = $res->fetchAllAssociative();
        $rows_num = count($rows);

        if ($rows_num == 1) {

            $yeti_rating = $rows[0]['rating'];
            $yeti_name = $rows[0]['name'];
            $yeti_height = $rows[0]['height'];
            $yeti_weight = $rows[0]['weight'];
            $yeti_address = $rows[0]['address'];
            $yeti_photo = $rows[0]['photo'];


            $photo_dir = $this->getParameter('photos_directory_url');
            return $this->render('yeti/show.html.twig', [
                'yeti_id' => $yeti_id, 'yeti_name' => $yeti_name, 'yeti_height' => $yeti_height, 'yeti_weight' => $yeti_weight, 'yeti_address' => $yeti_address, 'yeti_photo' => $photo_dir.$yeti_photo
            ]);
        }

    }
}
?>