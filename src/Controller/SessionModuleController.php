<?php

namespace App\Controller;


use App\Entity\SessionModule;
use App\Form\SessionModuleType;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\SessionModuleRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SessionModuleController extends AbstractController
{
    #[Route('/sessionModule', name: 'app_sessionModule')]
    public function index(SessionModuleRepository $sessionModuleRepository): Response
    {
        $sessionModules = $sessionModuleRepository->findBy([], ["nomSessionModule" => "ASC"]); // ORDER BY nomSessionModule ASC
        
        return $this->render('sessionModule/index.html.twig', [
            'sessionModules' => $sessionModules,
        ]);
    }



    #[Route('/sessionModule/new', name: 'new_sessionModule')] // 'new_sessionModule' est un nom cohérent qui décrit bien la fonction
    #[Route('/sessionModule/{id}/edit', name: 'edit_sessionModule')] // 'edit_sessionModule' est un nom cohérent qui décrit bien la fonction attendue
    public function new_edit(SessionModule $sessionModule = null, Request $request, EntityManagerInterface $entityManager): Response // pour ajouter un sessionModule à notre BDD
    {
        // 1. si pas de stagiaire, on crée un nouveau stagiaire (un objet stagiaire est bien créé ici) - s'il existe déjà, pas besoin de le créer
        if(!$sessionModule) {
            $sessionModule = new SessionModule();
        }

        // 2. on crée le formulaire à partir de SessionModuleType (on veut ce modèle là bien entendu)
        $form = $this->createForm(SessionModuleType::class, $sessionModule); // c'est bien la méthode createForm() qui permet de créer le formulaire

        // 4. le traitement s'effectue ici ! si le formulaire soumis est correct, on fera l'insertion en BDD
        $form->handleRequest($request);

        // bloc qui concerne la soumission
        if ($form->isSubmitted() && $form->isValid()) {
            
            $sessionModule = $form->getData(); // on récupère les données du formulaire dans notre objet categorie
            
            $entityManager->persist($sessionModule); // équivaut à la méthode prepare() en PDO

            $entityManager->flush(); // équivaut à la méthode execute() en PDOStatement

            // redirection vers la liste de sessionModules (si formulaire soumis et formulaire valide)
            return $this->redirectToRoute('app_sessionModule');
        }

        // 3. on affiche le formulaire créé dans la page dédiée à cet affichage -> {{ form(formAddCategorie) }} --> affichage par défaut 
        return $this->render('sessionModule/new.html.twig', [ // 'categorie/new.html.twig' -> vue dédiée à l'affichage du formulaire : on crée un nouveau fichier dans le dossier categorie
            // 'form' => $form,  on fait passer une variable form qui prend la valeur $form
            // on change le nom pour éviter toute ambiguité 'form' -> 'formAddCategorie' comme expliqué dans new.html.twig
            'formAddSessionModule' => $form,
            'edit' => $sessionModule->getId() // comportement booléen
        ]);
    }


    
    #[Route('/sessionModule/{id}/delete', name: 'delete_sessionModule')]
    public function delete(SessionModule $sessionModule, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($sessionModule); // on enlève le sessionModule ciblé de la collection de sessionModules
        $entityManager->flush(); // on effectue la requête SQL : DELETE FROM

        return $this->redirectToRoute('app_sessionModule'); // après une suppression, on redirige vers la liste de sessionModules
    }
}
