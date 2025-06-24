<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\Security;

final class UserController extends AbstractController
{
    private Security $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    #[Route('/user', name: 'app_user')]
    public function user(Request $request, EntityManagerInterface $entityManager): Response
    {
        // Get the currently logged-in user
        $user = $this->security->getUser();

        if (!$user) {
            throw $this->createAccessDeniedException('You must be logged in to access this page');
        }

        // Ensure the user has a default profile picture if none exists
        if (!$user->getPfp()) {
            $user->setPfp('default-profile.png');
        }
        // Create the form with the existing user data
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $imageFile */
            $imageFile = $form->get('imageFile')->getData();

            if ($imageFile) {
                // Generate a unique file name
                $safeFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = 'img/pizza/' . $safeFilename . '-' . uniqid() . '.' . $imageFile->guessExtension();

                // Move the file to the directory where images are stored
                $imageFile->move(
                    $this->getParameter('uploads_directory'), // Ensure this parameter exists in services.yaml
                    $newFilename
                );

                // Update the 'pfp' field in the User entity
                $user->setPfp($newFilename);
            }



            // Persist changes and flush to the database
            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('success', 'User updated successfully!');

            return $this->redirectToRoute('app_user');
        }

        return $this->render('user/index.html.twig', [
            'form' => $form->createView(),
            'user' => $user,
        ]);
    }
}
