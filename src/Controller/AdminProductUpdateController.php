<?php

namespace App\Controller;

use App\Entity\Pizza;
use App\Form\ProductUpdateType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class AdminProductUpdateController extends AbstractController
{
    #[IsGranted('ROLE_ADMIN')]
    #[Route('/admin/product/update/{id}', name: 'app_admin_product_update')]
    public function updateProduct(Request $request, EntityManagerInterface $entityManager, int $id): Response
    {
        // Fetch the category by id
        $product = $entityManager->getRepository(Pizza::class)->find($id);

        if (!$product) {
            throw $this->createNotFoundException('Category not found');
        }

        // Create the form with the existing category data
        $form = $this->createForm(ProductUpdateType::class, $product);
        $form->handleRequest($request);

        // Check if the form was submitted and is valid
        if ($form->isSubmitted() && $form->isValid()) {
            // Get the uploaded image file (if any)
            /** @var UploadedFile $imageFile */
            $imageFile = $form->get('image')->getData();

            if ($imageFile) {
                // Generate a unique file name for the image
                $safeFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = 'img/pizza/' . $safeFilename . '-' . uniqid() . '.' . $imageFile->guessExtension();

                // Move the file to the directory where images are stored
                $imageFile->move(
                    $this->getParameter('uploads_directory'), // images_directory is configured in services.yaml
                    $newFilename
                );

                // Update the 'image' field in the Catagory entity with only the filename (not path)
                $product->setImage($newFilename); // Store 'img/pizza/filename.jpg'
            }

            // Persist the changes
            $entityManager->persist($product);
            $entityManager->flush();

            // Add success flash message
            $this->addFlash('success', 'Category updated successfully!');

            // Redirect to the same page or another route
            return $this->redirectToRoute('app_admin_product_home', ['id' => $id]);
        }

        // Render the form in the template
        return $this->render('admin_home/productUpdate.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
