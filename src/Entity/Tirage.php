<?php

namespace App\Entity;

use App\Repository\TirageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TirageRepository::class)
 */
class Tirage
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $nombre;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $dateTirage;

    /**
     * @ORM\ManyToOne(targetEntity=Loto::class, inversedBy="tirages")
     * @ORM\JoinColumn(nullable=false)
     */
    private $loto;

    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     */
    private $joueur;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $ordre;

    /**
     * @ORM\ManyToOne(targetEntity=Combinaison::class, inversedBy="tirages")
     */
    private $combinaison;

    public function __construct()
    {
        $this->loto = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?int
    {
        return $this->nombre;
    }

    public function setNombre(int $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getDateTirage(): ?\DateTimeInterface
    {
        return $this->dateTirage;
    }

    public function setDateTirage(?\DateTimeInterface $dateTirage): self
    {
        $this->dateTirage = $dateTirage;

        return $this;
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

    public function __toString(): string
    {
        return $this->nombre;
    }

    public function getOrdre(): ?int
    {
        return $this->ordre;
    }

    public function setOrdre(?int $ordre): self
    {
        $this->ordre = $ordre;

        return $this;
    }

    public function getCombinaison(): ?Combinaison
    {
        return $this->combinaison;
    }

    public function setCombinaison(?Combinaison $combinaison): self
    {
        $this->combinaison = $combinaison;

        return $this;
    }
}
