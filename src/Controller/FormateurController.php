<?php

namespace App\Controller;


use App\Entity\Formateur;
use App\Form\FormateurType;
use App\Repository\FormateurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FormateurController extends AbstractController
{
    #[Route('/formateur', name: 'app_formateur')]
    public function index(FormateurRepository $formateurRepository): Response
    {
        $formateurs = $formateurRepository->findBy([], ["nom" => "ASC"]); // ORDER BY nom ASC
        
        return $this->render('formateur/index.html.twig', [
            'formateurs' => $formateurs,
        ]);
    }



    #[Route('/formateur/new', name: 'new_formateur')] // 'new_formateur' est un nom cohérent qui décrit bien la fonction
    #[Route('/formateur/{id}/edit', name: 'edit_formateur')] // 'edit_formateur' est un nom cohérent qui décrit bien la fonction attendue
    public function new_edit(Formateur $formateur = null, Request $request, EntityManagerInterface $entityManager): Response // pour ajouter un formateur à notre BDD
    {
        // 1. si pas de formateur, on crée un nouveau formateur (un objet formateur est bien créé ici) - s'il existe déjà, pas besoin de le créer
        if(!$formateur) {
            $formateur = new Formateur();
        }

        // 2. on crée le formulaire à partir de FormateurType (on veut ce modèle là bien entendu)
        $form = $this->createForm(FormateurType::class, $formateur); // c'est bien la méthode createForm() qui permet de créer le formulaire

        // 4. le traitement s'effectue ici ! si le formulaire soumis est correct, on fera l'insertion en BDD
        $form->handleRequest($request);

        // bloc qui concerne la soumission
        if ($form->isSubmitted() && $form->isValid()) {
            
            $formateur = $form->getData(); // on récupère les données du formulaire dans notre objet formateur
            
            $entityManager->persist($formateur); // équivaut à la méthode prepare() en PDO

            $entityManager->flush(); // équivaut à la méthode execute() en PDOStatement

            // redirection vers la liste de formateurs (si formulaire soumis et formulaire valide)
            return $this->redirectToRoute('app_formateur');
        }

        // 3. on affiche le formulaire créé dans la page dédiée à cet affichage -> {{ form(formAddFormateur) }} --> affichage par défaut 
        return $this->render('formateur/new.html.twig', [ // 'stagiaire/new.html.twig' -> vue dédiée à l'affichage du formulaire : on crée un nouveau fichier dans le dossier stagiaire
            // 'form' => $form,  on fait passer une variable form qui prend la valeur $form
            // on change le nom pour éviter toute ambiguité 'form' -> 'formAddStagiaire' comme expliqué dans new.html.twig
            'formAddFormateur' => $form,
            'edit' => $formateur->getId() // comportement booléen
        ]);
    }



    #[Route('/formateur/{id}/delete', name: 'delete_formateur')]
    public function delete(Formateur $formateur, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($formateur); // on enlève le formateur ciblé de la collection de formateurs
        $entityManager->flush(); // on effectue la requête SQL : DELETE FROM

        return $this->redirectToRoute('app_Fformateur'); // après une suppression, on redirige vers la liste de formateurs
    }


    
    #[Route('/formateur/{id}', name: 'show_formateur')]
    public function show(Formateur $formateur): Response
    {
        return $this->render('formateur/show.html.twig', [
            'formateur' => $formateur,
        ]);
    }
}
