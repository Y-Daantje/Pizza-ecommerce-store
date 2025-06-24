<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Video2Controller extends AbstractController
{
    #[Route('/vid2', name: 'app_vid2')]
    public function index(): Response
    {
        $title = 'pizza la dushi';
        return $this->render('index/vid2.html.twig', [
            'controller_name' => 'Video2Controller',
            'project_title' => $title,
        ]);
    }
}
