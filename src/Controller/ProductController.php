<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    #[Route('/', name: 'product_list')]
    public function index(ProductRepository $productRepo): Response
    {
        $products = $productRepo->findAll();

        return $this->render('product/index.html.twig', [
            'products' => $products,
        ]);
    }

    #[Route('/product/{id}', name: 'product')]
    public function product(ProductRepository $productRepo, $id = null): Response
    {
        $product = $productRepo->find($id);
        if (!$product){
            $this->addFlash('error', 'Produit inexistant, veuillez relancer votre recherche.');
            return $this->redirectToRoute('product_list');
        }

        return $this->render('product/product.html.twig', [
            'product' => $product,
        ]);
    }

    #[Route('/add_product/', name: 'add_product')]
    public function add_product(Request $request, EntityManagerInterface $em): Response
    {

        $product = new Product();
        $form = $this->createForm(ProductType::class, $product );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $em->persist($product);
            $em->flush();

            $this->addFlash('success', "Ajout d'un produit réussi." );


            return $this->redirectToRoute('product_list');
        }
        return $this->render('product/edit_product.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/edit_product/{id}', name: 'edit_product')]
    public function edit_product(Request $request, ProductRepository $productRepo, EntityManagerInterface $em, $id = null): Response
    {
        $product = $productRepo->find($id);
        if (!$product){
            $this->addFlash('error', 'Produit inexistant, veuillez relancer votre recherche.');
            return $this->redirectToRoute('product_list');
        }

        $form = $this->createForm(ProductType::class, $product );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

            $em->flush();

            $this->addFlash('success', "Mise à jour du produit réussi." );

            return $this->redirectToRoute('product_list');
        }
        return $this->render('product/edit_product.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
