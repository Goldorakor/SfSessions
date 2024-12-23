<?php

namespace App\Form;

use App\Entity\Session;
use App\Entity\Stagiaire;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class StagiaireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'attr' => [
                    'class' => 'form-control' // équivaut à attribuer la valeur 'form-control' à l'attribut 'class' dans la balise input -> <input type="text" id="name" name="name" class="form-control" />
                ]
            ])

            ->add('prenom', TextType::class, [
                'attr' => [
                    'class' => 'form-control' // équivaut à attribuer la valeur 'form-control' à l'attribut 'class' dans la balise input -> <input type="text" id="name" name="name" class="form-control" />
                ]
            ])

            ->add('adresse', TextType::class, [
                'attr' => [
                    'class' => 'form-control' // équivaut à attribuer la valeur 'form-control' à l'attribut 'class' dans la balise input -> <input type="text" id="name" name="name" class="form-control" />
                ]
            ])

            ->add('codePostal', TextType::class, [
                'attr' => [
                    'class' => 'form-control' // équivaut à attribuer la valeur 'form-control' à l'attribut 'class' dans la balise input -> <input type="text" id="name" name="name" class="form-control" />
                ]
            ])

            ->add('ville', TextType::class, [
                'attr' => [
                    'class' => 'form-control' // équivaut à attribuer la valeur 'form-control' à l'attribut 'class' dans la balise input -> <input type="text" id="name" name="name" class="form-control" />
                ]
            ])

            /* pour le,moment, je ne veux pas pouvoir ajouter des sessions à un stagiaire en cours de création
            ->add('sessions', EntityType::class, [
                'class' => Session::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
            */

             
            // je rajoute à la main un bouton pour valider le formulaire
             ->add('valider', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-primary' // équivaut à attribuer la valeur 'form-control' à l'attribut 'class' dans la balise input -> <input type="text" id="name" name="name" class="form-control" />
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Stagiaire::class,
        ]);
    }
}
