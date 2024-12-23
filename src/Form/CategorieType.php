<?php

namespace App\Form;

use App\Entity\Categorie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class CategorieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomCategorie', TextType::class, [
                'attr' => [
                    'class' => 'form-control' // équivaut à attribuer la valeur 'form-control' à l'attribut 'class' dans la balise input -> <input type="text" id="name" name="name" class="form-control" />
                ]
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
            'data_class' => Categorie::class,
        ]);
    }
}
