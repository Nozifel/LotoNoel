<?php

namespace App\Entity;

use App\Repository\LotoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=LotoRepository::class)
 */
class Loto
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     *
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Assert\NotBlank
     */
    private $nom;

    /**
     * @ORM\Column(type="date")
     *
     * @Assert\NotNull
     * @Assert\GreaterThan("today")
     */
    private $date_debut;

    /**
     * @ORM\Column(type="date")
     *
     * @Assert\NotNull
     * @Assert\GreaterThan(propertyPath="date_debut")
     */
    private $date_fin;

    /**
     * @ORM\Column(type="integer")
     *
     * @Assert\NotNull
     */
    private $hauteur_grille;

    /**
     * @ORM\Column(type="integer")
     *
     * @Assert\NotNull
     */
    private $largeur_grille;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, inversedBy="lotos")
     *
     * @Assert\NotNull
     */
    private $joueurs;

    public function __construct()
    {
        $this->joueurs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->date_debut;
    }

    public function setDateDebut(\DateTimeInterface $date_debut): self
    {
        $this->date_debut = $date_debut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->date_fin;
    }

    public function setDateFin(\DateTimeInterface $date_fin): self
    {
        $this->date_fin = $date_fin;

        return $this;
    }

    public function getHauteurGrille(): ?int
    {
        return $this->hauteur_grille;
    }

    public function setHauteurGrille(int $hauteur_grille): self
    {
        $this->hauteur_grille = $hauteur_grille;

        return $this;
    }

    public function getLargeurGrille(): ?int
    {
        return $this->largeur_grille;
    }

    public function setLargeurGrille(int $largeur_grille): self
    {
        $this->largeur_grille = $largeur_grille;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getJoueurs(): Collection
    {
        return $this->joueurs;
    }

    public function addJoueur(User $joueur): self
    {
        if (!$this->joueurs->contains($joueur)) {
            $this->joueurs[] = $joueur;
        }

        return $this;
    }

    public function removeJoueur(User $joueur): self
    {
        if ($this->joueurs->contains($joueur)) {
            $this->joueurs->removeElement($joueur);
        }

        return $this;
    }
}
