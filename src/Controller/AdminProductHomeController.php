<?php

namespace App\Controller;

use App\Entity\Pizza;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class AdminProductHomeController extends AbstractController
{
    #[IsGranted('ROLE_ADMIN')]
    #[Route('/admin/product/home', name: 'app_admin_product_home')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $pizzaVega = $entityManager->getRepository(Pizza::class)->findBy(['catagory_id' => 1]);
        $pizzaVlees = $entityManager->getRepository(Pizza::class)->findBy(['catagory_id' => 2]);
        $pizzaVis = $entityManager->getRepository(Pizza::class)->findBy(['catagory_id' => 3]);

        return $this->render('admin_home/productHome.html.twig', [
            'pizzaVegas' => $pizzaVega,
            'pizzasVleess' => $pizzaVlees,
            'pizzaViss' => $pizzaVis
        ]);
    }
}