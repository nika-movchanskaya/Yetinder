<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\DBAL\Connection;

class YetinderMainController extends AbstractController
{
    /**
     * @Route("/main", name="app_main")
     */
    public function main(Request $request, Connection $connection): Response
    {
          $queryBuilder = $connection->createQueryBuilder();

          $queryBuilder
            ->select('id', 'rating', 'name', 'height', 'weight', 'address')
            ->from('Yetis')
            ->orderBy('rating', 'DESC')
            ->setMaxResults(10);

          $res = $queryBuilder->execute();
          $rows = $res->fetchAllAssociative();
          $rows_num = count($rows);
          if ($rows_num > 0) {
            return $this->render('yeti/main.html.twig', ['rows' => $rows]);
          }
    }
}
?>