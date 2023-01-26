<?php

namespace App\Form;

use App\Entity\Ticket;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class NewTicketFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Sujet du ticket'
                ],
                'label' => 'Titre',
                'label_attr' => ['class' => 'my-2']
            ])
            ->add('content', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Description'
                ],
                'label' => 'Contenu',
                'label_attr' => ['class' => 'my-2']
            ])
            //->add('created_at')
            //->add('completed_at')
            //->add('user')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Ticket::class,
        ]);
    }
}
