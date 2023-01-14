<?php

namespace App\Controller;

use App\Form\ProductType;
use App\Form\UserInformationType;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OrderController extends AbstractController
{
    private RequestStack $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    #[Route('/order', name: 'order')]
    public function index(Request $request, ProductRepository $productRepo, EntityManagerInterface $em): Response
    {
        $user = $this->getUser();
        if (!$user){
            $this->addFlash('error', 'Merci de vous connecter pour passer commande.');
            return $this->redirectToRoute('login');
        }

        $sessionCart = $this->requestStack->getSession()->get('cart');
        if (!$sessionCart){
            $this->addFlash('error', 'Votre panier est vide.');
            return $this->redirectToRoute('product_list');
        }

        $cart = [];

        foreach ($sessionCart as $id => $quantity){
            $product = $productRepo->find($id);
            if($product){
                $cart[$id]=[
                    'quantity' => $quantity,
                    'product' => $product
                ];
            }
        }

        $form = $this->createForm(UserInformationType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $em->flush();

            return $this->redirectToRoute('order_confirmation');
        }

        return $this->render('order/index.html.twig', [
            'form' => $form->createView(),
            'cart' => $cart,
        ]);
    }

    #[Route('/order_confirmation', name: 'order_confirmation')]
    public function orderConfirmation(Request $request, ProductRepository $productRepo, EntityManagerInterface $em): Response
    {
        $user = $this->getUser();
        if (!$user){
            $this->addFlash('error', 'Merci de vous connecter pour passer commande.');
            return $this->redirectToRoute('login');
        }

        $sessionCart = $this->requestStack->getSession()->get('cart');
        if (!$sessionCart){
            $this->addFlash('error', 'Votre panier est vide.');
            return $this->redirectToRoute('product_list');
        }

        $cart = [];

        foreach ($sessionCart as $id => $quantity){
            $product = $productRepo->find($id);
            if($product){
                $cart[$id]=[
                    'quantity' => $quantity,
                    'product' => $product
                ];
            }
        }

        return $this->render('order/order_confirmation.html.twig', [
            'cart' => $cart,
        ]);
    }
}
