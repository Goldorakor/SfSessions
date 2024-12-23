<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\UX\Turbo\Attribute\Broadcast;
use App\Repository\SessionModuleRepository;
use Doctrine\Common\Collections\Collection; // rajouté à nla main
use Doctrine\Common\Collections\ArrayCollection; // rajouté à la main


#[ORM\Entity(repositoryClass: SessionModuleRepository::class)]
#[Broadcast]
class SessionModule
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 150)]
    private ?string $nomSessionModule = null;

    #[ORM\ManyToOne(inversedBy: 'sessionModules')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Categorie $categorie = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomSessionModule(): ?string
    {
        return $this->nomSessionModule;
    }

    public function setNomSessionModule(string $nomSessionModule): static
    {
        $this->nomSessionModule = $nomSessionModule;

        return $this;
    }

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): static
    {
        $this->categorie = $categorie;

        return $this;
    }

    public function __toString() 
    {
        return $this->nomSessionModule;
    }
}
