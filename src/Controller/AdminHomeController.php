<?php

namespace App\Controller;


use App\Entity\Purchase;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class AdminHomeController extends AbstractController
{
    #[IsGranted('ROLE_ADMIN')]
    #[Route('/admin/home', name: 'app_admin_home')]
    public function index(EntityManagerInterface $entityManager, Request $request): Response
    {
        $orders = $entityManager->getRepository(Purchase::class)
            ->createQueryBuilder('p')
            ->leftJoin('p.pizzaPurchases', 'pp') // ✅ Correct: "pizzaPurchases"
            ->addSelect('pp')
            ->leftJoin('pp.pizza', 'pz') // ✅ Join with Pizza entity
            ->addSelect('pz')
            ->getQuery()
            ->getResult();

        return $this->render('admin_home/index.html.twig', [
            'orders' => $orders,
        ]);
    }
}


