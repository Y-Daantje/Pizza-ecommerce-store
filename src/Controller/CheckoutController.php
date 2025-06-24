<?php

namespace App\Controller;

use App\Entity\Pizza;
use App\Entity\PizzaPurchase;
use App\Entity\Purchase;
use App\Form\CheckoutType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

final class CheckoutController extends AbstractController
{
    #[Route('/checkout', name: 'app_checkout')]
    public function checkout(Request $request, SessionInterface $session, EntityManagerInterface $em): Response
    {
        // Retrieve shopping cart items from session
        $shoppingCart = $session->get('shopping_cart', []);

        // Create the checkout form
        $form = $this->createForm(CheckoutType::class);

        // Pre-fill form data if the user is logged in
        if ($this->getUser()) {
            $user = $this->getUser(); // Get logged-in user

            // Set form data to logged-in user's info
            $form->get('firstName')->setData($user->getFirstName());
            $form->get('lastName')->setData($user->getLastName());
            $form->get('phoneNumber')->setData($user->getPhoneNumber());
            $form->get('email')->setData($user->getEmail());
            $form->get('address')->setData($user->getAddress());
            $form->get('zipp_code')->setData($user->getZippCode());
        }



        $form->handleRequest($request);

        // Process form submission
        if ($form->isSubmitted() && $form->isValid()) {
            $purchase = $form->getData();

            $purchase->setOrderNumber(rand(100000, 999999)); // Random number between 100000 and 999999
            $status = "Your pizza order has been received! We're preparing your delicious pizza now.";
            $totalQuantity = 0;
            foreach ($shoppingCart as $item) {
                $pizzaPurchase = new PizzaPurchase();
                $pizzaPurchase-> setPurchase($purchase);
                $pizzaPurchase-> setPizza($em ->getRepository(Pizza::class)->find($item['id']));
                $pizzaPurchase-> setQuantity($item['quantity']);
                $pizzaPurchase->setSize($size ?? 'M');
                $pizzaPurchase-> setSauce($item['sauce']);
                $pizzaPurchase-> setImage2($item['image']);
                $pizzaPurchase-> setPizzaName($item['name']);
                $pizzaPurchase-> setPrice($item['price']);
                $pizzaPurchase-> setStatus($status);
                $purchase->addPizzaPurchase($pizzaPurchase);
                $totalQuantity = $totalQuantity + $item['quantity'];
            }
            $purchase->setQuantity($totalQuantity);

            // Set the pizza details in the purchase object


            // Persist purchase data to the database
            $em->persist($purchase);
            $em->flush();

            // Clear shopping cart after purchase
            $session->set('shopping_cart', []);

            // Redirect to confirmation or payment page
            return $this->redirectToRoute('app_purchase'); // Change route as needed
        }

        // Render the checkout page with form and shopping cart
        return $this->render('checkout/index.html.twig', [
            'shopping_cart' => $shoppingCart,
            'form' => $form->createView(),
        ]);
    }
}
