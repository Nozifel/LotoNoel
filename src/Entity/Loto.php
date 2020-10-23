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

    /**
     * @ORM\OneToMany(targetEntity=Tirage::class, mappedBy="loto", orphanRemoval=true, cascade={"persist"})
     */
    private $tirages;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $tiragesParJour;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="lotosAuteur")
     * @ORM\JoinColumn(nullable=false)
     */
    private $auteur;

    /**
     * @ORM\Column(type="boolean")
     */
    private $autoriserEditionGrilles = false;

    /**
     * @ORM\OneToMany(targetEntity=Combinaison::class, mappedBy="loto", orphanRemoval=true, cascade={"persist"})
     */
    private $combinaisons;

    /**
     * @ORM\OneToMany(targetEntity=Grille::class, mappedBy="loto")
     */
    private $grilles;

    public function __construct()
    {
        $this->combinaisons = new ArrayCollection();
        $this->joueurs = new ArrayCollection();
        $this->grilles = new ArrayCollection();
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

    /**
     * @return Collection|Tirage[]
     */
    public function getTirages(): Collection
    {
        return $this->tirages;
    }

    public function addTirage(Tirage $tirage): self
    {
        if (!$this->tirages->contains($tirage)) {
            $this->tirages[] = $tirage;
            $tirage->setLoto($this);
        }

        return $this;
    }

    public function removeTirage(Tirage $tirage): self
    {
        if ($this->tirages->contains($tirage)) {
            $this->tirages->removeElement($tirage);
            // set the owning side to null (unless already changed)
            if ($tirage->getLoto() === $this) {
                $tirage->setLoto(null);
            }
        }

        return $this;
    }

    public function getTiragesParJour(): ?int
    {
        return $this->tiragesParJour;
    }

    public function setTiragesParJour(?int $tiragesParJour): self
    {
        $this->tiragesParJour = $tiragesParJour;

        return $this;
    }

    public function getAuteur(): ?User
    {
        return $this->auteur;
    }

    public function setAuteur(?User $auteur): self
    {
        $this->auteur = $auteur;

        return $this;
    }

    public function getAutoriserEditionGrilles(): ?bool
    {
        return $this->autoriserEditionGrilles;
    }

    public function setAutoriserEditionGrilles(bool $autoriserEditionGrilles): self
    {
        $this->autoriserEditionGrilles = $autoriserEditionGrilles;

        return $this;
    }

    /**
     * @return Collection|Combinaison[]
     */
    public function getCombinaisons(): Collection
    {
        return $this->combinaisons;
    }

    public function addCombinaison(Combinaison $combinaison): self
    {
        if (!$this->combinaisons->contains($combinaison)) {
            $this->combinaisons[] = $combinaison;
            $combinaison->setLoto($this);
        }

        return $this;
    }

    public function removeCombinaison(Combinaison $combinaison): self
    {
        if ($this->combinaisons->contains($combinaison)) {
            $this->combinaisons->removeElement($combinaison);
            // set the owning side to null (unless already changed)
            if ($combinaison->getLoto() === $this) {
                $combinaison->setLoto(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Grille[]
     */
    public function getGrilles(): Collection
    {
        return $this->grilles;
    }

    public function addGrille(Grille $grille): self
    {
        if (!$this->grilles->contains($grille)) {
            $this->grilles[] = $grille;
            $grille->setLoto($this);
        }

        return $this;
    }

    public function removeGrille(Grille $grille): self
    {
        if ($this->grilles->contains($grille)) {
            $this->grilles->removeElement($grille);
            // set the owning side to null (unless already changed)
            if ($grille->getLoto() === $this) {
                $grille->setLoto(null);
            }
        }

        return $this;
    }
}
