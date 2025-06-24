<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class ProductUpdateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Pizza Name',
                'attr' => ['class' => 'form-control', 'placeholder' => 'Enter pizza name']
            ])
            ->add('image', FileType::class, [
                'mapped' => false,
                'required' => true,
                'constraints' => [
                    new File([  // ✅ Ensure this is using Symfony's Validator File class
                        'maxSize' => '2M',
                        'mimeTypes' => ['image/jpeg', 'image/png', 'image/webp'],
                        'mimeTypesMessage' => 'Please upload a valid image (JPEG, PNG, or WebP)',
                    ])
                ],
                'label' => 'Upload Image',
                'attr' => ['class' => 'form-control']
            ])
            ->add('price', NumberType::class, [
                'label' => 'Price',
                'attr' => ['class' => 'form-control', 'placeholder' => 'Enter pizza price'],
                'scale' => 2,  // Ensures 2 decimal places (for cents)
            ])
            ->add('discription', TextareaType::class, [
                'label' => 'Description',
                'attr' => ['class' => 'form-control', 'placeholder' => 'Enter pizza description']
            ])
            ->add('catagory_id', ChoiceType::class, [
                'label' => 'Category',
                'choices' => [
                    'Vegetarian Pizza' => 1,
                    'Meat Pizza' => 2,
                    'Fish Pizza' => 3,
                ],
                'expanded' => false, // Use a dropdown
                'multiple' => false, // Only one choice can be made
                'attr' => ['class' => 'form-select']
            ])
        ;
    }
}
