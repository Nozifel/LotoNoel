<?php

namespace App\Entity;

use App\Repository\CombinaisonRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CombinaisonRepository::class)
 */
class Combinaison
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private $pattern = [];

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $special;

    /**
     * @ORM\OneToOne(targetEntity=User::class, cascade={"persist", "remove"})
     */
    private $gagnant;

    /**
     * @ORM\ManyToOne(targetEntity=Loto::class, inversedBy="combinaisons")
     * @ORM\JoinColumn(nullable=false)
     */
    private $loto;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPattern(): ?array
    {
        return $this->pattern;
    }

    public function setPattern(?array $pattern): self
    {
        $this->pattern = $pattern;

        return $this;
    }

    public function getSpecial(): ?string
    {
        return $this->special;
    }

    public function setSpecial(?string $special): self
    {
        $this->special = $special;

        return $this;
    }

    public function getGagnant(): ?User
    {
        return $this->gagnant;
    }

    public function setGagnant(?User $gagnant): self
    {
        $this->gagnant = $gagnant;

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }
}
