<?php

namespace App\Controller;


use App\Repository\FormationRepository;
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
}