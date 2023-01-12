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

    #[Route('/add_product', name: 'add_product')]
    #[Route('/edit_product/{id}', name: 'edit_product')]
    public function edit_product(Request $request, ProductRepository $productRepo, EntityManagerInterface $em, $id = null): Response
    {
        if ($id){
            $product = $productRepo->find($id);
            $title = 'Modifier un produit';
            if (!$product){
                $this->addFlash('error', 'Produit inexistant, veuillez relancer votre recherche.');
                return $this->redirectToRoute('product_list');
            }
        }
        else{
            $product = new Product();
            $title = 'Ajouter un produit';
        }

        $form = $this->createForm(ProductType::class, $product );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $em->persist($product);
            $em->flush();

            $this->addFlash('success', "Enregistrement réussi." );

            return $this->redirectToRoute('product_list');
        }
        return $this->render('product/edit_product.html.twig', [
            'form' => $form->createView(),
            'title' => $title,
        ]);
    }
}
