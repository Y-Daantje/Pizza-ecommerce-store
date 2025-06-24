<?php

namespace App\Controller;

use App\Entity\Catagory;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class AdminCatagoryHomeController extends AbstractController
{
    #[IsGranted('ROLE_ADMIN')]
    #[Route('/admin/catagory/home', name: 'app_admin_catagory_home')]
    public function index(EntityManagerInterface $entityManager): Response
    {

        $catagory = $entityManager->getRepository(Catagory::class)->findAll();
        return $this->render('admin_home/catagory.html.twig', [
            'catagorys' => $catagory
        ]);
    }
}
