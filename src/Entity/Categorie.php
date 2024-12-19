<?php

namespace App\Entity;

use App\Repository\CategorieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\UX\Turbo\Attribute\Broadcast;

#[ORM\Entity(repositoryClass: CategorieRepository::class)]
#[Broadcast]
class Categorie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $nomCategorie = null;

    /**
     * @var Collection<int, SessionModule>
     */
    #[ORM\OneToMany(targetEntity: SessionModule::class, mappedBy: 'categorie', orphanRemoval: true)]
    private Collection $sessionModules;

    public function __construct()
    {
        $this->sessionModules = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomCategorie(): ?string
    {
        return $this->nomCategorie;
    }

    public function setNomCategorie(string $nomCategorie): static
    {
        $this->nomCategorie = $nomCategorie;

        return $this;
    }

    /**
     * @return Collection<int, SessionModule>
     */
    public function getSessionModules(): Collection
    {
        return $this->sessionModules;
    }

    public function addSessionModule(SessionModule $sessionModule): static
    {
        if (!$this->sessionModules->contains($sessionModule)) {
            $this->sessionModules->add($sessionModule);
            $sessionModule->setCategorie($this);
        }

        return $this;
    }

    public function removeSessionModule(SessionModule $sessionModule): static
    {
        if ($this->sessionModules->removeElement($sessionModule)) {
            // set the owning side to null (unless already changed)
            if ($sessionModule->getCategorie() === $this) {
                $sessionModule->setCategorie(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->nomCategorie;
    }
}
