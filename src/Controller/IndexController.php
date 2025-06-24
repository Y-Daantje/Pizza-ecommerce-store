<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    #[Route('/', name: 'app_index')]
    public function index(): Response
    {
        $title = 'pizza la dushi';
        if ($this->getUser()) {
            if ($this->isGranted("ROLE_ADMIN")){
                return $this->redirectToRoute('app_admin_home');
            } else {
                return $this->redirectToRoute('app_mainpage');
            }
        } else {
            return $this->render('index/index.html.twig', [
                'controller_name' => 'IndexController',
                'project_title' => $title,
            ]);
        }


    }
}
