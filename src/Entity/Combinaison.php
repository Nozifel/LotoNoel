<?php

namespace App\Entity;

use App\Repository\CombinaisonRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
     * @ORM\ManyToOne(targetEntity=User::class, cascade={"persist", "remove"})
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

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $numero;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type;

    /**
     * @ORM\OneToMany(targetEntity=Tirage::class, mappedBy="combinaison")
     */
    private $tirages;

    public function __construct()
    {
        $this->tirages = new ArrayCollection();
    }

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

    public function getNumero(): ?int
    {
        return $this->numero;
    }

    public function setNumero(?int $numero): self
    {
        $this->numero = $numero;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

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
            $tirage->setCombinaison($this);
        }

        return $this;
    }

    public function removeTirage(Tirage $tirage): self
    {
        if ($this->tirages->contains($tirage)) {
            $this->tirages->removeElement($tirage);
            // set the owning side to null (unless already changed)
            if ($tirage->getCombinaison() === $this) {
                $tirage->setCombinaison(null);
            }
        }

        return $this;
    }
}
