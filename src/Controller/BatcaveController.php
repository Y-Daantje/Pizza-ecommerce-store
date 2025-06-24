<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class BatcaveController extends AbstractController
{
    #[Route('/batcave', name: 'app_batcave')]
    public function index(): Response
    {
        return $this->render('batcave/index.html.twig', [
            'controller_name' => 'BatcaveController',
        ]);
    }



}
