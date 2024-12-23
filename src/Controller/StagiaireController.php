<?php

namespace App\Controller;

use App\Entity\Stagiaire;
use App\Form\StagiaireType;
use App\Repository\StagiaireRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class StagiaireController extends AbstractController
{
    #[Route('/stagiaire', name: 'app_stagiaire')]
    public function index(StagiaireRepository $stagiaireRepository): Response
    {
        $stagiaires = $stagiaireRepository->findBy([], ["nom" => "ASC"]); // ORDER BY nom ASC
        
        return $this->render('stagiaire/index.html.twig', [
            'stagiaires' => $stagiaires,
        ]);
    }


    #[Route('/stagiaire/new', name: 'new_stagiaire')] // 'new_stagiaire' est un nom cohérent qui décrit bien la fonction

    #[Route('/stagiaire/{id}/edit', name: 'edit_stagiaire')] // 'edit_stagiaire' est un nom cohérent qui décrit bien la fonction attendue

    public function new_edit(Stagiaire $stagiaire = null, Request $request, EntityManagerInterface $entityManager): Response // pour ajouter une entreprise à notre BDD
    {
       
        // 1. si pas de stagiaire, on crée un nouveau stagiaire (un objet stagiaire est bien créé ici) - s'il existe déjà, pas besoin de le créer
        if(!$stagiaire) {
            $stagiaire = new Stagiaire();
        }


        // 2. on crée le formulaire à partir de StagiaireType (on veut ce modèle là bien entendu)
        $form = $this->createForm(StagiaireType::class, $stagiaire); // c'est bien la méthode createForm() qui permet de créer le formulaire

        // 4. le traitement s'effectue ici ! si le formulaire soumis est correct, on fera l'insertion en BDD
        $form->handleRequest($request);

        // bloc qui concerne la soumission
        if ($form->isSubmitted() && $form->isValid()) {
            
            $stagiaire = $form->getData(); // on récupère les données du formulaire dans notre objet stagiaire
            
            $entityManager->persist($stagiaire); // équivaut à la méthode prepare() en PDO

            $entityManager->flush(); // équivaut à la méthode execute() en PDOStatement

            // redirection vers la liste de stagiaires (si formulaire soumis et formulaire valide)
            return $this->redirectToRoute('app_stagiaire');
        }


        // 3. on affiche le formulaire créé dans la page dédiée à cet affichage -> {{ form(formAddStagiaire) }} --> affichage par défaut 
        return $this->render('stagiaire/new.html.twig', [ // 'stagiaire/new.html.twig' -> vue dédiée à l'affichage du formulaire : on crée un nouveau fichier dans le dossier stagiaire
            // 'form' => $form,  on fait passer une variable form qui prend la valeur $form
            // on change le nom pour éviter toute ambiguité 'form' -> 'formAddStagiaire' comme expliqué dans new.html.twig
            'formAddStagiaire' => $form,
            'edit' => $stagiaire->getId() // comportement booléen
        ]);
    }


    #[Route('/stagiaire/{id}/delete', name: 'delete_stagiaire')]
    public function delete(Stagiaire $stagiaire, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($stagiaire); // on enlève le stagiaire ciblé de la collection de stagiaires
        $entityManager->flush(); // on effectue la requête SQL : DELETE FROM

        return $this->redirectToRoute('app_stagiaire'); // après une suppression, on redirige vers la liste de stagiaires
    }

    
    #[Route('/stagiaire/{id}', name: 'show_stagiaire')]
    public function show(Stagiaire $stagiaire): Response
    {
        return $this->render('stagiaire/show.html.twig', [
            'stagiaire' => $stagiaire,
        ]);
    }

}
