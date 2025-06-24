<?php

namespace App\Controller;

use App\Entity\Pizza;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class BatcavemainController extends AbstractController
{
    #[Route('/batcavemain', name: 'app_batcavemain')]
    public function index(EntityManagerInterface $entityManager ,Request $request): Response
    {

        $batpizzas = $entityManager->getRepository(Pizza::class)->findBy(['catagory_id' => 4]);
        return $this->render('batcave/batCaveMain.html.twig', [
            'batpizzas' => $batpizzas,
        ]);
    }
}
