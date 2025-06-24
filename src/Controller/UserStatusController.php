<?php

namespace App\Controller;

use App\Entity\Purchase;
use App\Entity\PizzaPurchase;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class UserStatusController extends AbstractController
{
    #[Route('/user/status', name: 'app_user_status')]
    public function index(EntityManagerInterface $entityManager, Request $request): Response
    {
        // Get the logged-in user (modify based on your authentication setup)
        $user = $this->getUser();

        // Fetch only the purchases belonging to the logged-in user
        $orders = $entityManager->getRepository(Purchase::class)
            ->createQueryBuilder('p')
            ->leftJoin('p.pizzaPurchases', 'pp') // ✅ Correct: "pizzaPurchases"
            ->addSelect('pp')
            ->leftJoin('pp.pizza', 'pz') // ✅ Join with Pizza entity
            ->addSelect('pz')
            ->where('p.email = :userEmail') // Assuming orders are linked to user email
            ->setParameter('userEmail', $this->getUser()->getEmail())
            ->getQuery()
            ->getResult();

        return $this->render('user_status/index.html.twig', [
            'orders' => $orders,
        ]);
    }
}
