<?php

namespace App\Controller;

use DateTime;
use App\Entity\Session;
use App\Repository\SessionRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SessionController extends AbstractController
{
    #[Route('/session', name: 'app_session')]
    public function index(SessionRepository $sessionRepository): Response
    {
        $sessions = $sessionRepository->findBy([], ["nomSession" => "ASC"]); // ORDER BY nomSession ASC
        
        return $this->render('session/index.html.twig', [
            'sessions' => $sessions,
        ]);
    }

    
    #[Route('/session/{id}', name: 'show_session')]
    public function show(Session $session): Response
    {
        $now = new DateTime();

        return $this->render('session/show.html.twig', [
            'session' => $session,
            'now' => $now,

        ]);
    }

}
