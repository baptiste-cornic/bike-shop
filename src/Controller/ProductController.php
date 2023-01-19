<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Exception\FileNotFoundException;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class ProductController extends AbstractController
{
    #[Route('/', name: 'product_list')]
    public function index(ProductRepository $productRepo): Response
    {
        $products = $productRepo->findBy(['isValid'=> true], ['productType' => 'ASC']);

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
    public function edit_product(Request $request, ProductRepository $productRepo, EntityManagerInterface $em,
                                 SluggerInterface $slugger ,$id = null): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        try{
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

                $picture = $form->get('picture')->getData();
                if (!$picture)
                    throw new FileException('Merci de séléctionner une image pour votre produit.');

                $safeFilename  = $slugger->slug($product->getName());
                $newFilename = $safeFilename.'_'.uniqid().'.'.$picture->guessExtension();

                try {
                    $picture->move(
                        $this->getParameter('img_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    $this->addFlash('error', 'Image invalide.');
                    return $this->redirectToRoute('admin');
                }

                $product->setPicture($newFilename);

                $em->persist($product);
                $em->flush();

                $this->addFlash('success', "Enregistrement réussi." );

                return $this->redirectToRoute('admin');
            }
        }catch (FileNotFoundException $exception){
            $this->addFlash('error', $exception->getMessage());
        }


        return $this->render('product/edit_product.html.twig', [
            'form' => $form->createView(),
            'title' => $title,
            'product' => $product,
        ]);
    }

    #[Route('/update_valid_product', name: 'update_valid_product')]
    public function updateValidProduct(Request $request, ProductRepository $productRepo, EntityManagerInterface $em): JsonResponse{
        try {
            $this->denyAccessUnlessGranted('ROLE_ADMIN');

            $productId = $request->getContent();
            if (!$productId)
                throw new \Exception('Id incorrect.');

            /** @var Product $product */
            $product = $productRepo->find($productId);
            if (!$product)
                throw new \Exception("Ce produit n'existe pas.");

            $product->setIsValid(!$product->isIsValid());
            $em->flush();

            return new JsonResponse(['status' => 'success']);

        }catch (\Exception $exception){
            return new JsonResponse(['status' => 'error', 'message' => $exception->getMessage()]);
        }
    }
}
