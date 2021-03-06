<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isVerified = false;

    /**
     * @ORM\ManyToMany(targetEntity=Loto::class, mappedBy="joueurs")
     */
    private $lotos;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $prenom;

    /**
     * @ORM\OneToMany(targetEntity=Loto::class, mappedBy="auteur", orphanRemoval=true)
     */
    private $lotosAuteur;

    /**
     * @ORM\OneToMany(targetEntity=Grille::class, mappedBy="joueur", orphanRemoval=true)
     */
    private $grille;

    public function __construct()
    {
        $this->lotos = new ArrayCollection();
        $this->lotosAuteur = new ArrayCollection();
        $this->grille = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): self
    {
        $this->isVerified = $isVerified;

        return $this;
    }

    /**
     * @return Collection|Loto[]
     */
    public function getLotos(): Collection
    {
        return $this->lotos;
    }

    public function addLoto(Loto $loto): self
    {
        if (!$this->lotos->contains($loto)) {
            $this->lotos[] = $loto;
            $loto->addJoueur($this);
        }

        return $this;
    }

    public function removeLoto(Loto $loto): self
    {
        if ($this->lotos->contains($loto)) {
            $this->lotos->removeElement($loto);
            $loto->removeJoueur($this);
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->email;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * @return Collection|Loto[]
     */
    public function getLotosAuteur(): Collection
    {
        return $this->lotosAuteur;
    }

    public function addLotosAuteur(Loto $lotosAuteur): self
    {
        if (!$this->lotosAuteur->contains($lotosAuteur)) {
            $this->lotosAuteur[] = $lotosAuteur;
            $lotosAuteur->setAuteur($this);
        }

        return $this;
    }

    public function removeLotosAuteur(Loto $lotosAuteur): self
    {
        if ($this->lotosAuteur->contains($lotosAuteur)) {
            $this->lotosAuteur->removeElement($lotosAuteur);
            // set the owning side to null (unless already changed)
            if ($lotosAuteur->getAuteur() === $this) {
                $lotosAuteur->setAuteur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Grille[]
     */
    public function getGrille(): Collection
    {
        return $this->grille;
    }

    public function addGrille(Grille $grille): self
    {
        if (!$this->grille->contains($grille)) {
            $this->grille[] = $grille;
            $grille->setJoueur($this);
        }

        return $this;
    }

    public function removeGrille(Grille $grille): self
    {
        if ($this->grille->contains($grille)) {
            $this->grille->removeElement($grille);
            // set the owning side to null (unless already changed)
            if ($grille->getJoueur() === $this) {
                $grille->setJoueur(null);
            }
        }

        return $this;
    }
}
