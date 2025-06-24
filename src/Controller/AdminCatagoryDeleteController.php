<?php

namespace App\Controller;

use App\Entity\Catagory;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class AdminCatagoryDeleteController extends AbstractController
{
    #[IsGranted('ROLE_ADMIN')]
    #[Route('/admin/catagory/delete/{id}', name: 'app_admin_catagory_delete')]
    public function deleteCategory(Request $request, EntityManagerInterface $entityManager, int $id): Response
    {
        // Retrieve the category entity by ID
        $category = $entityManager->getRepository(Catagory::class)->find($id);

        // Check if the category exists
        if (!$category) {
            // If not found, add a flash message and redirect
            $this->addFlash('error', 'Category not found');
            return $this->redirectToRoute('app_admin_catagory_home'); // Assuming you have a route for listing categories
        }

        // Remove the category and flush changes to the database
        $entityManager->remove($category);
        $entityManager->flush();

        // Add success flash message and redirect to the category list page
        $this->addFlash('success', 'Category has been deleted successfully');
        return $this->redirectToRoute('app_admin_catagory_home'); // Adjust this route name if needed
    }
}
