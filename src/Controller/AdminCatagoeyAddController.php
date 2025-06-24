<?php

namespace App\Controller;

use App\Entity\Catagory;
use App\Form\CategoryType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\String\Slugger\SluggerInterface;

final class AdminCatagoeyAddController extends AbstractController
{
    #[IsGranted('ROLE_ADMIN')]
    #[Route('/admin/catagoey/add', name: 'app_admin_catagoey_add')]
    public function index(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        $catagory = new Catagory();
        $form = $this->createForm(CategoryType::class, $catagory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('imageFile')->getData(); // Get the uploaded file

            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename); // Generate a safe filename
                $newFilename = 'img/pizza/' . $safeFilename . '-' . uniqid() . '.' . $imageFile->guessExtension(); // Add 'img/pizza/' prefix

                try {
                    // Move the file to the directory defined in uploads_directory
                    $imageFile->move(
                        $this->getParameter('uploads_directory'), // Path to store images
                        $newFilename
                    );
                    $catagory->setImage($newFilename); // Store the image path with the prefix
                } catch (FileException $e) {
                    $this->addFlash('error', 'Could not upload file.');
                }
            }

            // Persist the category object and save to the database
            $entityManager->persist($catagory);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_catagory_home'); // Redirect after success
        }

        return $this->render('admin_home/catagoryAdd.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
