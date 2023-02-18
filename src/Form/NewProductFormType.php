<?php

namespace App\Form;

use App\Entity\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NewProductFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Nom du produit'
                ],
                'label' => 'Titre',
                'label_attr' => ['class' => 'my-2']
            ])
            ->add('type', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Type de produit'
                ],
                'label' => 'Type produit',
                'label_attr' => ['class' => 'my-2']
            ])
            ->add('type_price', MoneyType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Prix HT du produit'
                ],
                'label' => 'Prix du produit',
                'label_attr' => ['class' => 'my-2']
            ])
            ->add('description', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Description'
                ],
                'label' => 'Description du produit',
                'label_attr' => ['class' => 'my-2']
            ])
            ->add('picture', FileType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Picture file'
                ],
                'label' => 'Image du produit',
                'label_attr' => ['class' => 'my-2']
            ])
            //->add('formule')
            //->add('price')
            //->add('description')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
