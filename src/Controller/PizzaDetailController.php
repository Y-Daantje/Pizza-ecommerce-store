<?php

namespace App\Controller;

use App\Entity\Pizza;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class PizzaDetailController extends AbstractController
{
    #[Route('/pizza/detail/{category_id}', name: 'app_pizza_detail')]
    public function index(EntityManagerInterface $entityManager, $category_id): Response
    {
        // Fetch pizzas that belong to the selected category
        $pizzas = $entityManager->getRepository(Pizza::class)->findBy(['catagory_id' => $category_id]);

        // Pass the pizzas and category_id to the template
        return $this->render('pizza_detail/index.html.twig', [
            'pizzas' => $pizzas,
            'category_id' => $category_id,
        ]);
    }

}
