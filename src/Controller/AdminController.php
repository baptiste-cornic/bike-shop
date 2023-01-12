<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'admin')]
    public function index(ProductRepository $productRepo): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $products = $productRepo->findAll();

        return $this->render('admin/index.html.twig', [
            'products' => $products,
        ]);
    }
}
