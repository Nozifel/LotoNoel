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
     * @ORM\Column(type="boolean")
     */
    private $estTirer;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $dateTirage;

    /**
     * @ORM\ManyToOne(targetEntity=Loto::class, inversedBy="tirages")
     * @ORM\JoinColumn(nullable=false)
     */
    private $loto;

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

    public function getEstTirer(): ?bool
    {
        return $this->estTirer;
    }

    public function setEstTirer(bool $estTirer): self
    {
        $this->estTirer = $estTirer;

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
}
