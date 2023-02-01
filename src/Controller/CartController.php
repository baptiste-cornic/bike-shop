<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use App\Service\CartService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    private RequestStack $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    #[Route('/cart', name: 'cart')]
    public function index(ProductRepository $productRepo, CartService $cartService): Response
    {
       $cart = $cartService->getCart();

        return $this->render('cart/index.html.twig', [
            'cart' => $cart['cart'],
            'totalPrice' => $cart['totalPrice']
        ]);
    }

    #[Route('/increase_cart/{id}', name: 'increase_cart')]
    public function increase_cart(Request $request,ProductRepository $productRepo, $id = null): RedirectResponse {
        if (!$id){
            $this->addFlash('error', 'Erreur' );
            return $this->redirectToRoute('product_list');
        }

        $product = $productRepo->find($id);
        if (!$product->isIsValid()){
            $this->addFlash('error', "Ce produit n'est pas disponible pour le moment" );
            return $this->redirectToRoute('product_list');
        }

        $referer = $request->headers->get('referer');

        $session = $this->requestStack->getSession();

        $cart = $session->get('cart', []);

        if (!empty($cart[$id]))
            $cart[$id]++;
        else
            $cart[$id] = 1;

        $session->set('cart', $cart);

        $this->addFlash('success', "Le produit a été ajouté à votre panier." );
        return $this->redirect($referer);
    }

    #[Route('/decrease_cart/{id}', name: 'decrease_cart')]
    public function decrease_cart(Request $request, $id = null): RedirectResponse{
        if (!$id){
            $this->addFlash('error', 'Erreur' );
            return $this->redirectToRoute('product_list');
        }
        $referer = $request->headers->get('referer');

        $session = $this->requestStack->getSession();

        $cart = $session->get('cart', []);

        if($cart[$id] <= 1) {
            unset($cart[$id]);
        }

        if (!empty($cart[$id])){
            $cart[$id] = $cart[$id] -1;
        }

        $session->set('cart', $cart);

        $this->addFlash('success', "Le produit a été retiré à votre panier." );
        return $this->redirect($referer);
    }

    #[Route('/remove_cart/{id}', name: 'remove_cart')]
    public function remove_cart(Request $request, $id = null): RedirectResponse{
        if (!$id){
            $this->addFlash('error', 'Erreur' );
            return $this->redirectToRoute('product');
        }

        $referer = $request->headers->get('referer');

        $session = $this->requestStack->getSession();
        $cart = $session->get('cart', []);

        if($cart[$id]) {
            unset($cart[$id]);
        }
        $session->set('cart', $cart);

        $this->addFlash('success', "Le produit a été retiré à votre panier." );
        return $this->redirect($referer);
    }
}
