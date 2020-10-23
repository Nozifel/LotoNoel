<?php

namespace App\Entity;

use App\Repository\GrilleRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=GrilleRepository::class)
 */
class Grille
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Loto::class, inversedBy="grilles")
     */
    private $loto;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="grille")
     * @ORM\JoinColumn(nullable=false)
     */
    private $joueur;

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private $grille = [];

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $complete;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLoto(): ?Loto
    {
        return $this->loto;
    }

    public function setLoto(?Loto $loto): self
    {
        $this->loto = $loto;

        return $this;
    }

    public function getJoueur(): ?User
    {
        return $this->joueur;
    }

    public function setJoueur(?User $joueur): self
    {
        $this->joueur = $joueur;

        return $this;
    }

    public function getGrille(): ?array
    {
        return $this->grille;
    }

    public function setGrille(?array $grille): self
    {
        $this->grille = $grille;

        return $this;
    }

    public function getComplete(): ?\DateTimeInterface
    {
        return $this->complete;
    }

    public function setComplete(?\DateTimeInterface $complete): self
    {
        $this->complete = $complete;

        return $this;
    }
}
