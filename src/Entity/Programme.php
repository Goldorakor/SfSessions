<?php

namespace App\Entity;

// use App\Entity\Programme;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ProgrammeRepository;
use Symfony\UX\Turbo\Attribute\Broadcast;


#[ORM\Entity(repositoryClass: ProgrammeRepository::class)]
#[Broadcast]
class Programme
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $nbJours = null;

    #[ORM\ManyToOne(inversedBy: 'programmes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Session $session = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?SessionModule $sessionModule = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNbJours(): ?int
    {
        return $this->nbJours;
    }

    public function setNbJours(int $nbJours): static
    {
        $this->nbJours = $nbJours;

        return $this;
    }

    public function getSession(): ?Session
    {
        return $this->session;
    }

    public function setSession(?Session $session): static
    {
        $this->session = $session;

        return $this;
    }

    public function getSessionModule(): ?SessionModule
    {
        return $this->sessionModule;
    }

    public function setSessionModule(?SessionModule $sessionModule): static
    {
        $this->sessionModule = $sessionModule;

        return $this;
    }

    public function __toString() {
        return $this->getSessionModule()." (".$this->getSessionModule()->getCategorie().")".$this->getNbJours();
    }
}
