<?php

namespace App\Controller;


use App\Entity\Categorie;
use App\Form\CategorieType;
use App\Repository\CategorieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CategorieController extends AbstractController
{
    #[Route('/categorie', name: 'app_categorie')]
    public function index(CategorieRepository $categorieRepository): Response
    {
        $categories = $categorieRepository->findBy([], ["nomCategorie" => "ASC"]); // ORDER BY nomCategorie ASC
        
        return $this->render('categorie/index.html.twig', [
            'categories' => $categories,
        ]);
    }


    #[Route('/categorie/new', name: 'new_categorie')] // 'new_categorie' est un nom cohérent qui décrit bien la fonction

    #[Route('/categorie/{id}/edit', name: 'edit_categorie')] // 'edit_categorie' est un nom cohérent qui décrit bien la fonction attendue

    public function new_edit(Categorie $categorie = null, Request $request, EntityManagerInterface $entityManager): Response // pour ajouter une entreprise à notre BDD
    {
       
        // 1. si pas de stagiaire, on crée un nouveau stagiaire (un objet stagiaire est bien créé ici) - s'il existe déjà, pas besoin de le créer
        if(!$categorie) {
            $categorie = new Categorie();
        }


        // 2. on crée le formulaire à partir de CategorieType (on veut ce modèle là bien entendu)
        $form = $this->createForm(CategorieType::class, $categorie); // c'est bien la méthode createForm() qui permet de créer le formulaire

        // 4. le traitement s'effectue ici ! si le formulaire soumis est correct, on fera l'insertion en BDD
        $form->handleRequest($request);

        // bloc qui concerne la soumission
        if ($form->isSubmitted() && $form->isValid()) {
            
            $categorie = $form->getData(); // on récupère les données du formulaire dans notre objet categorie
            
            $entityManager->persist($categorie); // équivaut à la méthode prepare() en PDO

            $entityManager->flush(); // équivaut à la méthode execute() en PDOStatement

            // redirection vers la liste de categories (si formulaire soumis et formulaire valide)
            return $this->redirectToRoute('app_categorie');
        }


        // 3. on affiche le formulaire créé dans la page dédiée à cet affichage -> {{ form(formAddCategorie) }} --> affichage par défaut 
        return $this->render('categorie/new.html.twig', [ // 'categorie/new.html.twig' -> vue dédiée à l'affichage du formulaire : on crée un nouveau fichier dans le dossier categorie
            // 'form' => $form,  on fait passer une variable form qui prend la valeur $form
            // on change le nom pour éviter toute ambiguité 'form' -> 'formAddCategorie' comme expliqué dans new.html.twig
            'formAddCategorie' => $form,
            'edit' => $categorie->getId() // comportement booléen
        ]);
    }


    #[Route('/categorie/{id}/delete', name: 'delete_categorie')]
    public function delete(Categorie $categorie, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($categorie); // on enlève la catégorie ciblée de la collection de categories
        $entityManager->flush(); // on effectue la requête SQL : DELETE FROM

        return $this->redirectToRoute('app_categorie'); // après une suppression, on redirige vers la liste de catégories
    }



    #[Route('/categorie/{id}', name: 'show_categorie')]
    public function show(Categorie $categorie): Response
    {
        return $this->render('categorie/show.html.twig', [
            'categorie' => $categorie,
        ]);
    }

}
