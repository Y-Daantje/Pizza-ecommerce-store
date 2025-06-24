<?php

namespace App\Controller;

use App\Entity\Pizza;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class AllPizzaController extends AbstractController
{
    #[Route('/all/pizza', name: 'app_all_pizza')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $pizzaVega = $entityManager->getRepository(Pizza::class)->findBy(['catagory_id' => 1]);
        $pizzaVlees = $entityManager->getRepository(Pizza::class)->findBy(['catagory_id' => 2]);
        $pizzaVis = $entityManager->getRepository(Pizza::class)->findBy(['catagory_id' => 3]);

        return $this->render('all_pizza/index.html.twig', [
            'pizzaVegas' => $pizzaVega,
            'pizzasVleess' => $pizzaVlees,
            'pizzaViss' => $pizzaVis
        ]);
    }
}
