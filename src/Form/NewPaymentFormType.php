<?php

namespace App\Form;

use App\Entity\Payment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class NewPaymentFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            //->add('total_price')
            //->add('status')
            /*->add('nb_days', IntegerType::class, [
                'attr' => [
                    'class' => 'form-control my-4'                    
                ],
                'label' => 'Nombre de jour(s)',
                'label_attr' => ['class' => 'my-2']
            ])
            ->add('nb_weeks', IntegerType::class, [
                'attr' => [
                    'class' => 'form-control my-4'
                ],
                'label' => 'Nombre de semaine(s)',
                'label_attr' => ['class' => 'my-2']
            ])
            ->add('nb_months', IntegerType::class, [
                'attr' => [
                    'class' => 'form-control my-4'
                ],
                'label' => 'Nombre de mois',
                'label_attr' => ['class' => 'my-2']
            ])*/
            //->add('created_at')
            //->add('completed_at')
            //->add('price_unit')
            //->add('user')
            ->add('product', IntegerType::class, [
                'attr' => [
                    'class' => 'form-control my-4'
                ],
                'label' => 'Sélection formule',
                'label_attr' => ['class' => 'my-2']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Payment::class,
        ]);
    }
}