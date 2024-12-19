<?php

namespace App\Controller;

use App\Repository\SessionModuleRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SessionModuleController extends AbstractController
{
    #[Route('/sessionmodule', name: 'app_sessionmodule')]
    public function index(SessionModuleRepository $sessionModuleRepository): Response
    {
        $sessionModules = $sessionModuleRepository->findBy([], ["nomSessionModule" => "ASC"]); // ORDER BY nomSessionModule ASC
        
        return $this->render('sessionmodule/index.html.twig', [
            'sessionModules' => $sessionModules,
        ]);
    }
}
