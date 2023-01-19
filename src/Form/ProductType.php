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
use Symfony\Component\Validator\Constraints\File;

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
            'Pliant' => 'Pliant',
            'Gravel' => 'Gravel'
            ];

        $builder
            ->add('name', TextType::class, [
                'label' => false,
                'required' => true,
            ])
            ->add('brand', TextType::class, [
                'label' => false,
                'required' => true,
            ])
            ->add('picture', FileType::class, [
                'label' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/png',
                            'image/jpeg',
                        ],
                        'mimeTypesMessage' => 'Veuillez sélectionner une image valide.',
                    ])
                ],
                'data_class' => null,
            ])
            ->add('productType', ChoiceType::class, [
                'label' => false,
                'required' => true,
                'choices' => $productType,
            ])
            ->add('price', MoneyType::class, [
                'label' => false,
                'required' => true,
                'divisor' => 100,
                'currency' => ''
                ])
            ->add('description', TextareaType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'rows' => 3
                ]
            ])
            ->add('frame', TextType::class, [
                'label' => false,
                'required' => false,
            ])
            ->add('fork', TextType::class, [
                'label' => false,
                'required' => false,
            ])
            ->add('suspension', TextType::class, [
                'label' => false,
                'required' => false,
            ])
            ->add('brakeType', TextType::class, [
                'label' => false,
                'required' => false,
            ])
            ->add('saddle', TextType::class, [
                'label' => false,
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
