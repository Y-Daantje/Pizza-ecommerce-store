<?php

namespace App\Controller;

use App\Entity\Pizza;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class PizzaRealDetailController extends AbstractController
{
    #[Route('/pizza/real/detail/{id}', name: 'app_pizza_real_detail')]
    public function index(EntityManagerInterface $entityManager, $id): Response
    {

        $pizzas = $entityManager->getRepository(Pizza::class)->findBy(['id' => $id]);
        return $this->render('pizza_real_detail/index.html.twig', [
            'pizzas' => $pizzas,
            'id' => $id,
        ]);
    }
}
