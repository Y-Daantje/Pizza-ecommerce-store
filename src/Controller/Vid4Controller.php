<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class Vid4Controller extends AbstractController
{
    #[Route('/vid4', name: 'app_vid4')]
    public function index(): Response
    {
        return $this->render('batcave/vid4.html.twig', [
            'controller_name' => 'Vid4Controller',
        ]);
    }
}
