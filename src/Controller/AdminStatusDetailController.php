<?php

namespace App\Controller;

use App\Entity\Purchase;
use App\Entity\PizzaPurchase;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class AdminStatusDetailController extends AbstractController
{
    #[Route('/admin/status/detail/{id}', name: 'app_admin_status_detail')]
    public function index(EntityManagerInterface $entityManager, $id): Response
    {
        // Retrieve the specific PizzaPurchase by ID
        $pizzaPurchase = $entityManager->getRepository(PizzaPurchase::class)
            ->createQueryBuilder('pp')
            ->leftJoin('pp.pizza', 'pz')
            ->addSelect('pz')
            ->where('pp.id = :id') // Filter by pizza purchase ID
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult(); // Get a single result or null if not found

        // If no matching PizzaPurchase found, throw an exception or handle it as needed
        if (!$pizzaPurchase) {
            throw $this->createNotFoundException('Pizza purchase not found.');
        }

        // Get the associated Purchase (order) information if needed
        $purchase = $pizzaPurchase->getPurchase();

        return $this->render('admin_home/statusDetail.html.twig', [
            'pizzaPurchase' => $pizzaPurchase,
            'purchase' => $purchase,
        ]);
    }
}
