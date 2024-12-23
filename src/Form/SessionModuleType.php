<?php

namespace App\Form;

use App\Entity\Categorie;
use App\Entity\SessionModule;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class SessionModuleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomSessionModule', TextType::class, [
                'attr' => [
                    'class' => 'form-control' // équivaut à attribuer la valeur 'form-control' à l'attribut 'class' dans la balise input -> <input type="text" id="name" name="name" class="form-control" />
                ]
            ])

            ->add('categorie', EntityType::class, [
                'class' => Categorie::class,
                'choice_label' => 'nomCategorie', // 'nomCategorie' plutôt que 'id'
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
            'data_class' => SessionModule::class,
        ]);
    }
}
