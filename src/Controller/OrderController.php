<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\OrderProduct;
use App\Form\ProductType;
use App\Form\UserInformationType;
use App\Repository\ProductRepository;
use App\Service\CartService;
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
    public function index(Request $request, ProductRepository $productRepo, EntityManagerInterface $em, CartService $cartService): Response
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

        $cart = $cartService->getCart();

        $form = $this->createForm(UserInformationType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $em->flush();

            return $this->redirectToRoute('order_confirmation');
        }

        return $this->render('order/index.html.twig', [
            'form' => $form->createView(),
            'cart' => $cart['cart'],
        ]);
    }

    #[Route('/order_confirmation', name: 'order_confirmation')]
    public function orderConfirmation(Request $request, ProductRepository $productRepo, EntityManagerInterface $em,
                                      CartService $cartService): Response
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

        $cart = $cartService->getCart();

        \Stripe\Stripe::setApiKey('sk_test_51M7bsdCZpiMH9jLxOZdLAeHz0mJNNMwqMnCPYTBn0qMWRULF9J34YXgaijklermh3CTWRFr3jbFm5W5uO1USPamr00jwUkIY7Z');

        // Create a PaymentIntent with amount and currency
        $paymentIntent = \Stripe\PaymentIntent::create([
            'amount' => $cart['totalPrice'] * 100,
            'currency' => 'eur',
            'automatic_payment_methods' => [
                'enabled' => true,
            ],
        ]);

        return $this->render('order/order_confirmation.html.twig', [
            'cart' => $cart['cart'],
            'clientSecret' => $paymentIntent->client_secret,
            'totalPrice' => $cart['totalPrice'],
        ]);
    }

    #[Route('/order_validation', name: 'order_validation')]
    public function orderValidation(ProductRepository $productRepo, EntityManagerInterface $em){

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

        $totalPrice = 0;
        $productsTab = [];

        foreach ($sessionCart as $id => $quantity){
            $product = $productRepo->find($id);
            $product->quantity = $quantity;
            if($product){
                $totalPrice = $totalPrice + ($quantity * $product->getPrice());
                $productsTab[] = $product;
            }
        }

        $order = new Order();
        $order->setUser($this->getUser())
            ->setPrice($totalPrice);

        $em->persist($order);

        foreach ($productsTab as $product){
            $orderProduct = new OrderProduct();
            $orderProduct->setOrder($order)
                ->setProduct($product)
                ->setUnitPrice($product->getPrice())
                ->setQuantity($product->quantity);
            $em->persist($orderProduct);
        }

        $em->flush();

        $this->requestStack->getSession()->remove('cart');

        $this->addFlash('success', 'Paiement effectué avec succès, votre commande vous sera livré prochainement.');
        return $this->redirectToRoute('product_list');
    }
}
