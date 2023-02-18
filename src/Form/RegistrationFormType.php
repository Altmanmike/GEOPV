<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Entrer votre mail ex: nom@domaine.fr'
                ],
                'constraints' => [
                    new NotBlank(),
                    new Regex([
                        'message' => 'Format invalide',                        
                        'pattern' => "/^\\S+@\\S+\\.\\S+$/" // la plus complex "/^[a-z0-9!#$%&'*+\\/=?^_`{|}~-]+(?:\\.[a-z0-9!#$%&'*+\\/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?$/"
                    ]),
                ],
                'label' => 'E-mail',
                'label_attr' => ['class' => 'my-2']
            ])   
            ->add('firstname', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Entrez votre prénom'
                ],
                'constraints' => [
                    new NotBlank(),
                    new Regex([
                        'message' => 'Un prénom ne peut contenir que des lettres...',                        
                        'pattern' => "/^[a-zA-Z-' ]*$/" //'^[a-zA-Z]'
                    ]),
                ],
                'label' => 'Prénom',
                'label_attr' => ['class' => 'my-2']
            ])
            ->add('lastname', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Entrez votre nom'
                ],
                'constraints' => [
                    new NotBlank(),
                    new Regex([
                        'message' => 'Un nom ne peut contenir que des lettres...',                        
                        'pattern' => "/^[a-zA-Z-' ]*$/" //'^[a-zA-Z]'
                    ]),
                ],
                'label' => 'Nom',
                'label_attr' => ['class' => 'my-2']
            ])
            ->add('phone', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Entrez votre n° de téléphone'
                ],
                'constraints' => [
                    new NotBlank(),
                    new Regex([
                        'message' => 'Un numéro de téléphone ne doit contenir que des chiffres...',                        
                        'pattern' => "/^(0|\+33)[1-9][0-9]{8}$/"     // "/^\\+?[1-9][0-9]{7,14}$/"    ^(0|\+33)[1-9]( *[0-9]{2}){4}+$                    
                    ]),
                ],
                'label' => 'Téléphone',
                'label_attr' => ['class' => 'my-2']
            ])
            ->add('company', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Entrez votre entreprise'
                ],
                'constraints' => [
                    new NotBlank(),
                    new Regex([
                        'message' => 'Un nom d\'entreprise ne peut contenir que des chiffres et des lettres...',                        
                        'pattern' => "/^[a-zA-Z0-9-' ]*$/" //'^[a-zA-Z0-9]'
                    ]),
                ],
                'label' => 'Entreprise',
                'label_attr' => ['class' => 'my-2']
            ])
            ->add('zipcode', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Entrez votre code postal'
                ],
                'constraints' => [
                    new NotBlank(),
                    new Regex([
                        'message' => 'Un code postal ne peut contenir que des chiffres et des lettres...',                        
                        'pattern' => "/^[a-zA-Z0-9]*$/"
                    ]),
                ],
                'label' => 'Code postal',
                'label_attr' => ['class' => 'my-2']
            ])
            ->add('city', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Entrez votre ville'
                ],
                'constraints' => [
                    new NotBlank(),
                    new Regex([
                        'message' => 'Un nom de ville ne peut contenir que des lettres...',                        
                        'pattern' => "/^[a-zA-Z-' ]*$/" //'^[a-zA-Z]'
                    ]),
                ],
                'label' => 'Ville',
                'label_attr' => ['class' => 'my-2']
            ])
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Entrez votre mot de passe',
                    'autocomplete' => 'new-password'                    
                ],
                'label' => 'Mot de passe',
                'label_attr' => ['class' => 'my-2'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrer un mot de passe',
                    ]),
                    new Regex([
                        'pattern' => "/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/", //'^[a-zA-Z0-9@]', //^(?=.*\d)(?=.*[A-Z])(?=.*[@#$%])(?!.*(.)\1{2}).*[a-z]/m
                        'message' => 'Votre mot de passe doit comporter au moins huit caractères, dont des lettres majuscules et minuscules, un chiffre et un symbole'
                    ]),
                    new Length([
                        'min' => 8,
                        'minMessage' => 'Votre mot de passe doit faire au moins {{ limit }} caractères',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],   
            ])
            /*->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'Vous devriez accepter nos termes..',
                    ]),
                ],
                'label' => 'En cochant, veuillez assumer avoir lu le document RGPD et accepter nos conditions générales d'utilisation..',
                'label_attr' => ['class' => 'my-2 me-2']
            ])*/
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
