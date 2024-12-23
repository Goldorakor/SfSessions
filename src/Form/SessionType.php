<?php

namespace App\Form;

use App\Entity\Session;
use App\Entity\Formateur;
use App\Entity\Formation;
use App\Entity\Stagiaire;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class SessionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomSession', TextType::class, [
                'attr' => [
                    'class' => 'form-control' // équivaut à attribuer la valeur 'form-control' à l'attribut 'class' dans la balise input -> <input type="text" id="name" name="name" class="form-control" />
                ]
            ])

            ->add('nbPlaces', IntegerType::class, [
                'attr' => [
                    'class' => 'form-control' // équivaut à attribuer la valeur 'form-control' à l'attribut 'class' dans la balise input -> <input type="text" id="name" name="name" class="form-control" />
                ]
            ])

            ->add('dateDebut', null, [
                'attr' => [
                    'class' => 'form-control' // équivaut à attribuer la valeur 'form-control' à l'attribut 'class' dans la balise input -> <input type="text" id="name" name="name" class="form-control" />
                ],
                'widget' => 'single_text',
            ], DateType::class)

            ->add('dateFin', null, [
                'attr' => [
                    'class' => 'form-control' // équivaut à attribuer la valeur 'form-control' à l'attribut 'class' dans la balise input -> <input type="text" id="name" name="name" class="form-control" />
                ],
                'widget' => 'single_text',
            ], DateType::class)

            ->add('formation', EntityType::class, [
                'class' => Formation::class,
                'choice_label' => 'nomFormation', // 'nomFormation' plutôt que 'id'
            ])


            /* je ne souhaite pas choisir des stagiaires lors de la création d'une session, je les ajouterai plus tard (dans le détail d'une session, je mettrai les boutons pour ajouter un apprenant)
            ->add('stagiaires', EntityType::class, [
                'class' => Stagiaire::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
            */


            ->add('formateur', EntityType::class, [
                'class' => Formateur::class,
                'choice_label' => 'nom', // 'nom' plutôt que 'id'
            ])

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
            'data_class' => Session::class,
        ]);
    }
}
