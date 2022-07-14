<?php

namespace App\Controller;

use Doctrine\DBAL\Connection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestDBController extends AbstractController
{
    /**
     * @Route("/testdb", name="app_testdb")
     */
    public function index(Connection $connection): Response
    {
	$rows = $connection->fetchAllAssociative('SELECT id, name FROM Yetis');
	echo $rows[0]['name'];

     }
}
?>
