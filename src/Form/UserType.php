<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', TextType::class, [
                'label' => 'email Name',
                'attr' => ['class' => 'form-control', 'placeholder' => 'Enter email']
            ])
            ->add('imageFile', FileType::class, [
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
            ->add('firstName', TextType::class, [
                'label' => 'firstName',
                'attr' => ['class' => 'form-control', 'placeholder' => 'Enter first name']
            ])
            ->add('lastName', TextType::class, [
                'label' => 'lastName',
                'attr' => ['class' => 'form-control', 'placeholder' => 'Enter last name']
            ])
            ->add('phoneNumber', NumberType::class, [
                'label' => 'phoneNumber',
                'attr' => ['class' => 'form-control', 'placeholder' => 'Enter phonenumber'],

            ])
            ->add('address', TextType::class, [
                'label' => 'address',
                'attr' => ['class' => 'form-control', 'placeholder' => 'Enter address']
            ])
            ->add('zipp_code', TextType::class, [
                'label' => 'zipp_code',
                'attr' => ['class' => 'form-control', 'placeholder' => 'Enter zip code']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
