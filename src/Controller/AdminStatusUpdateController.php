<?php

namespace App\Controller;

use App\Entity\PizzaPurchase;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class AdminStatusUpdateController extends AbstractController
{
    #[Route('/admin/status/update/{id}', name: 'app_admin_status_update')]
    public function index(EntityManagerInterface $entityManager, Request $request, $id): Response
    {
        // Retrieve the specific PizzaPurchase by ID
        $pizzaPurchase = $entityManager->getRepository(PizzaPurchase::class)
            ->find($id);

        // If no matching PizzaPurchase found, throw an exception or handle it
        if (!$pizzaPurchase) {
            throw $this->createNotFoundException('Pizza purchase not found.');
        }

        // Handle form submission if the status is being updated
        if ($request->isMethod('POST')) {
            $newStatus = $request->request->get('status'); // Retrieve the new status from the form

            if ($newStatus) {
                $pizzaPurchase->setStatus($newStatus); // Update the status
                $entityManager->flush(); // Persist the changes to the database

                // Redirect back with a success message
                $this->addFlash('success', 'Pizza purchase status updated successfully!');
                return $this->redirectToRoute('app_admin_status_update', ['id' => $id]);
            }
        }

        return $this->render('admin_home/statusUpdate.html.twig', [
            'pizzaPurchase' => $pizzaPurchase,
        ]);
    }
}