<?php

namespace App\Form;

use App\Entity\Ticket;
use App\Repository\CategoryTicketRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class NewTicketFormType extends AbstractType
{
    private CategoryTicketRepository $repoCT;
    private array $categories_ticket;

    public function __construct(CategoryTicketRepository $repoCT)
    {
        $this->repoCT = $repoCT;
        $this->categories_ticket = $this->repoCT->findAll();
    }

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
           ->add('category_ticket', ChoiceType::class, [
               'attr' => [
                   'class' => 'form-select',
                   'placeholder' => 'Catégorie'
               ],
               'label' => 'Catégorie de ticket',
               'label_attr' => ['class' => 'my-2'],
               'choices' => $this->categories_ticket,
               'choice_label' => function ($category_ticket) {
                   return $category_ticket->getTitle();
               },
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
