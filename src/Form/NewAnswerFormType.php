<?php

namespace App\Form;

use App\Entity\Answer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class NewAnswerFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('content', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Contenu de la réponse'
                ],
                'label' => 'Nouvelle réponse',
                'label_attr' => ['class' => 'my-2']
            ])
            //->add('created_at')
            /*->add('user', IntegerType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Utilisateur'
                ],
                'label' => 'Utilisateur N°',
                'label_attr' => ['class' => 'my-2']
            ])
            ->add('ticket', IntegerType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Numéro du ticket'
                ],
                'label' => 'Ticket N°',
                'label_attr' => ['class' => 'my-2']
            ])*/
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Answer::class,
        ]);
    }
}
