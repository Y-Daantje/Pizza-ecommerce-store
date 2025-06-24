<?php

namespace App\Controller;

use App\Entity\Pizza;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class AdminProductDetailController extends AbstractController
{
    #[IsGranted('ROLE_ADMIN')]
    #[Route('/admin/product/detail/{id}', name: 'app_admin_product_detail')]
    public function index(EntityManagerInterface $entityManager, $id): Response
    {

        $pizzas = $entityManager->getRepository(Pizza::class)->findBy(['id' => $id]);
        return $this->render('admin_home/productDetail.html.twig', [
            'pizzas' => $pizzas,
            'id' => $id,
        ]);
    }
}
