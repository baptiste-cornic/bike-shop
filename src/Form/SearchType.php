<?php

namespace App\Form;

use App\Repository\ProductRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\RangeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchType extends AbstractType
{
    private ProductRepository $productRepo;

    public function __construct(ProductRepository $productRepo){
        $this->productRepo = $productRepo;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $brandList = $this->productRepo->getProductBrand();

        $brandChoices= ['' => ''];

        foreach ($brandList as $brand){

            $brandChoices[$brand['brand']]= $brand['brand'];
        }

        $builder
            ->add('search', TextType::class, [
                'label' => false,
                'required' => false,

            ])
            ->add('brand', ChoiceType::class, [
                'label' => false,
                'required' => false,
                'choices' => $brandChoices,
                'multiple' => false,
                'expanded' => false,
                'attr' => [
                    'placeholder' => 'Choisir une marque'
                ]
            ])
            ->add('minPrice', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'placeholder' => 'min'
                ]
            ])
            ->add('maxPrice', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'placeholder' => 'max'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
