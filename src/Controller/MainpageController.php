<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Pizza;
use App\Entity\Catagory;


class MainpageController extends AbstractController
{
    #[Route('/mainpage', name: 'app_mainpage')]
    public function index(EntityManagerInterface $entityManager ,Request $request): Response
    {

        $batpizzas = $entityManager->getRepository(Pizza::class)->findBy(['catagory_id' => 4]);

        $pizzass = $entityManager->getRepository(Pizza::class)->findBy(['catagory_id' => 1]);

        $deals = $entityManager->getRepository(Pizza::class)->findBy(['catagory_id' => 5]);

        $box = $entityManager->getRepository(Pizza::class)->findBy(['catagory_id' => 6]);

        $burgers = $entityManager->getRepository(Pizza::class)->findBy(['catagory_id' => 7]);

        $pasta = $entityManager->getRepository(Pizza::class)->findBy(['catagory_id' => 8]);

        $desert = $entityManager->getRepository(Pizza::class)->findBy(['catagory_id' => 9]);

        $drinks = $entityManager->getRepository(Pizza::class)->findBy(['catagory_id' =>10]);

        $sauce = $entityManager->getRepository(Pizza::class)->findBy(['catagory_id' => 11]);

        $appetizer = $entityManager->getRepository(Pizza::class)->findBy(['catagory_id' => 12]);

        $rolls = $entityManager->getRepository(Pizza::class)->findBy(['catagory_id' => 13]);


        // Get all products and categories
        $pizza = $entityManager->getRepository(Pizza::class)->findAll();
        $categories = $entityManager->getRepository(Catagory::class)->findAll();

        return $this->render('index/mainpage.html.twig', [
            'pizzass' => $pizzass,
            'shopping_cart'=>$request->getSession()->get('shopping_cart'),
            'batpizzas' => $batpizzas,
            'boxs' => $box,
            'burgers' => $burgers,
            'pastas' => $pasta,
            'deserts' => $desert,
            'drinks' => $drinks,
            'deals' => $deals,
            'sauces' => $sauce,
            'appetizers' => $appetizer,
            'rolls' => $rolls,

            // All products & categories
            'pizza' => $pizza,
            'categories' => $categories,


        ]);
    }
}
