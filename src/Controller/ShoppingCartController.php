<?php

namespace App\Controller;

use App\Entity\Pizza;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class ShoppingCartController extends AbstractController
{
    #[Route('/shopping/cart', name: 'app_shopping_cart')]
    public function index(SessionInterface $session): Response
    {
        // Retrieve shopping cart from session
        $shoppingCart = $session->get('shopping_cart', []);

        // Render the shopping cart template with the stored products
        return $this->render('shopping_cart/productUpdate.html.twig', [
            'shopping_cart' => $shoppingCart,
        ]);
    }

    #[Route('/shopping/cart/add/{id}', name: 'app_add_shopping_cart', methods: ['GET', 'POST'])]

    public function add(int $id, EntityManagerInterface $em, SessionInterface $session, Request $request): Response

    {
        $product = $em->getRepository(Pizza::class)->find($id);

        if (!$product) {
            throw $this->createNotFoundException('Product not found');
        }

        // Define size-based prices manually
        $prices = [
            'S' => 5.99,
            'M' => 7.99,
            'L' => 9.99,
            'XL' => 12.99,
        ];


        // Get selected options from the form
        $size = $request->request->get('size');
        $sauce = $request->request->get('sauce', 'Tomato Sauce');
        $quantity = (int) $request->request->get('quantity', 1);

        // Get price based on selected size
        $price = $prices[$size] ?? $prices['M']; // Default to Medium price if not found

        if (!$session->get('shopping_cart')) {
        $session->set('shopping_cart', []);
        }


        $shoppingCart = $session->get('shopping_cart');

        // Unique cart key (prevents duplicate items)
        $cartKey = $id . '_' . $size . '_' . $sauce;

        if (isset($shoppingCart[$cartKey])) {
            // Update quantity if item exists
            $shoppingCart[$cartKey]['quantity'] += $quantity;
        } else {
            // Add new item to cart
            $shoppingCart[$cartKey] = [
                'id' => $product->getId(),
                'name' => $product->getName(),
                'price' => $price,
                'size' => $size,
                'sauce' => $sauce,
                'quantity' => $quantity,
                'image' => $product->getImage2()
            ];
        }

        $session->set('shopping_cart', $shoppingCart);


        // Add flash message for user feedback
        $this->addFlash('success', 'Product is toegevoegd aan winkelwagen!');

        return $this->redirectToRoute('app_mainpage');
    }

    #[Route('/shopping/cart/remove/{id}', name: 'app_remove_shopping_cart', methods: ['POST'])]
    public function remove(int $id, SessionInterface $session): Response
    {
        // Retrieve shopping cart from session
        $shoppingCart = $session->get('shopping_cart', []);

        // Loop through and remove all items with the same product ID
        foreach ($shoppingCart as $key => $item) {
            if ($item['id'] === $id) {
                unset($shoppingCart[$key]);
            }
        }

        // Save updated cart back to session
        $session->set('shopping_cart', $shoppingCart);

        // Flash message for feedback
        $this->addFlash('success', 'Product verwijderd uit winkelwagen!');

        return $this->redirectToRoute('app_mainpage');
    }

}
