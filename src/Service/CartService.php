<?php

namespace App\Service;

use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\RequestStack;

class CartService
{
    private ProductRepository $productRepo;
    private RequestStack $requestStack;

    public function __construct(ProductRepository $productRepo, RequestStack $requestStack,){
        $this->productRepo = $productRepo;
        $this->requestStack = $requestStack;
    }

    public function getCart(): array
    {
        $sessionCart = $this->requestStack->getSession()->get('cart');
        $cart = [];
        $totalPrice = 0;

        if ($sessionCart){
            foreach ($sessionCart as $id => $quantity){
                $product = $this->productRepo->find($id);
                if($product){
                    $totalPrice = $totalPrice + ($quantity * $product->getPrice());
                    $cart[$id]=[
                        'quantity' => $quantity,
                        'product' => $product
                    ];
                }
            }
        }

        return ['cart' => $cart, 'totalPrice' => $totalPrice];
    }
}