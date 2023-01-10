<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    #[Route('/', name: 'product_list')]
    public function index(ProductRepository $productRepo): Response
    {

        $products = $productRepo->findAll();
        //dd($products);

        return $this->render('product/index.html.twig', [
            'products' => $products,
        ]);
    }

    #[Route('/product/{id}', name: 'product')]
    public function product(ProductRepository $productRepo, $id = null): Response
    {

        $product = $productRepo->find($id);

        return $this->render('product/product.html.twig', [
            'product' => $product,
        ]);
    }

}
