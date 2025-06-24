<?php

namespace App\Controller;

use App\Entity\Pizza;
use App\Form\ProductType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\String\Slugger\SluggerInterface;

final class AdminProductAddController extends AbstractController
{
    #[IsGranted('ROLE_ADMIN')]
    #[Route('/admin/product/add', name: 'app_admin_product_add')]
    public function index(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        $pizza = new Pizza();

        $lastPizza = $entityManager->getRepository(Pizza::class)->findOneBy([], ['model_id' => 'DESC']);
        $modelId = $lastPizza ? $lastPizza->getModelId() + 1 : 1; // Set to 1 if no pizza exists
        $pizza->setModelId($modelId); // Assign the incremented model_id

        $form = $this->createForm(ProductType::class, $pizza);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('imageFile')->getData(); // Get the uploaded image file




            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename); // Make the filename safe
                $newFilename = 'img/pizza/' . $safeFilename . '-' . uniqid() . '.' . $imageFile->guessExtension(); // Add 'img/pizza/' prefix

                try {
                    // Move the file to the directory defined in uploads_directory
                    $imageFile->move(
                        $this->getParameter('uploads_directory'),
                        $newFilename
                    );

                    // Save the full path with 'img/pizza/' prefix in the entity
                    $pizza->setImage($newFilename);
                } catch (FileException $e) {
                    $this->addFlash('error', 'Could not upload file.');
                }
            }

            // Persist the pizza object (with the new image path and other details)
            $entityManager->persist($pizza);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_product_home'); // Redirect after success
        }

        return $this->render('admin_home/productAdd.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
