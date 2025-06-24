<?php

namespace App\Form;

use App\Entity\Purchase;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class CheckoutType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', TextType::class, [
                'label' => 'email Name',
                'attr' => ['class' => 'form-control', 'placeholder' => 'Enter email']
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
            ])
            // Only one Choice field for Delivery/Pickup Method
            ->add('deliveryMethod', ChoiceType::class, [
                'choices' => [
                    'Pickup' => 'pickup',
                    'Delivery' => 'delivery',
                ],
                'label' => 'Choose delivery method',
                'expanded' => true, // This makes it render as radio buttons
                'multiple' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Purchase::class,
        ]);
    }
}
