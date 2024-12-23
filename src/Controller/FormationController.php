<?php

namespace App\Controller;


use App\Entity\Formation;
use App\Form\FormationType;
use App\Repository\FormationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FormationController extends AbstractController
{
    #[Route('/formation', name: 'app_formation')]
    public function index(FormationRepository $formationRepository): Response
    {
        $formations = $formationRepository->findBy([], ["nomFormation" => "ASC"]); // ORDER BY nomFormation ASC

        return $this->render('formation/index.html.twig', [
            'formations' => $formations,
        ]);
    }


    #[Route('/formation/new', name: 'new_formation')] // 'new_formation' est un nom cohérent qui décrit bien la fonction

    #[Route('/formation/{id}/edit', name: 'edit_formation')] // 'edit_formation' est un nom cohérent qui décrit bien la fonction attendue

    public function new_edit(Formation $formation = null, Request $request, EntityManagerInterface $entityManager): Response // pour ajouter une formation à notre BDD
    {
       
        // 1. si pas de formation, on crée une nouvelle formation (un objet formation est bien créé ici) - s'il existe déjà, pas besoin de le créer
        if(!$formation) {
            $formation = new Formation();
        }


        // 2. on crée le formulaire à partir de FormationType (on veut ce modèle là bien entendu)
        $form = $this->createForm(FormationType::class, $formation); // c'est bien la méthode createForm() qui permet de créer le formulaire

        // 4. le traitement s'effectue ici ! si le formulaire soumis est correct, on fera l'insertion en BDD
        $form->handleRequest($request);

        // bloc qui concerne la soumission
        if ($form->isSubmitted() && $form->isValid()) {
            
            $formation = $form->getData(); // on récupère les données du formulaire dans notre objet categorie
            
            $entityManager->persist($formation); // équivaut à la méthode prepare() en PDO

            $entityManager->flush(); // équivaut à la méthode execute() en PDOStatement

            // redirection vers la liste de categories (si formulaire soumis et formulaire valide)
            return $this->redirectToRoute('app_formation');
        }


        // 3. on affiche le formulaire créé dans la page dédiée à cet affichage -> {{ form(formAddCategorie) }} --> affichage par défaut 
        return $this->render('formation/new.html.twig', [ // 'categorie/new.html.twig' -> vue dédiée à l'affichage du formulaire : on crée un nouveau fichier dans le dossier categorie
            // 'form' => $form,  on fait passer une variable form qui prend la valeur $form
            // on change le nom pour éviter toute ambiguité 'form' -> 'formAddCategorie' comme expliqué dans new.html.twig
            'formAddFormation' => $form,
            'edit' => $formation->getId() // comportement booléen
        ]);
    }


    #[Route('/formation/{id}/delete', name: 'delete_formation')]
    public function delete(Formation $formation, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($formation); // on enlève la formation ciblée de la collection de formations
        $entityManager->flush(); // on effectue la requête SQL : DELETE FROM

        return $this->redirectToRoute('app_formation'); // après une suppression, on redirige vers la liste de formations
    }
}
