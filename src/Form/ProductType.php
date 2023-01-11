<?php

namespace App\Form;

use App\Entity\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $productType = [
            'VTT' => 'VTT',
            'Route' => 'Route',
            'Electrique' => 'Electrique',
            'Urbain' => 'Urbain',
            'Cargo' => 'Cargo',
            'Pliant' => 'Pliant'
            ];

        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom',
                'required' => true,
            ])
            ->add('brand', TextType::class, [
                'label' => 'Marque',
                'required' => true,
            ])
            ->add('picture', FileType::class, [
                'label' => 'Photo',
                'required' => false,
            ])
            ->add('productType', ChoiceType::class, [
                'label' => 'Type du produit',
                'required' => true,
                'choices' => $productType,
            ])
            ->add('price', MoneyType::class, [
                'label' => 'Prix',
                'required' => true,
                'divisor' => 100,
                'currency' => ''
                ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'required' => false,
            ])
            ->add('frame', TextType::class, [
                'label' => 'Cadre',
                'required' => false,
            ])
            ->add('fork', TextType::class, [
                'label' => 'Fourche',
                'required' => false,
            ])
            ->add('suspension', TextType::class, [
                'label' => 'Suspension',
                'required' => false,
            ])
            ->add('brakeType', TextType::class, [
                'label' => 'Type de frein',
                'required' => false,
            ])
            ->add('saddle', TextType::class, [
                'label' => 'Selle',
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
