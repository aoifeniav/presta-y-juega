<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
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
     * @ORM\Column(type="string", length=50)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $surname;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $rating;

    /**
     * @ORM\OneToMany(targetEntity=Game::class, mappedBy="owner")
     */
    private $games;

    /**
     * @ORM\OneToMany(targetEntity=Operation::class, mappedBy="borrower")
     */
    private $operationsAsBorrower;

    /**
     * @ORM\OneToMany(targetEntity=Operation::class, mappedBy="lender")
     */
    private $operationsAsLender;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $province;

    public function __construct()
    {
        $this->games = new ArrayCollection();
        $this->operationsAsBorrower = new ArrayCollection();
        $this->operationsAsLender = new ArrayCollection();
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
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getSurname(): ?string
    {
        return $this->surname;
    }

    public function setSurname(string $surname): self
    {
        $this->surname = $surname;

        return $this;
    }

    public function getRating(): ?int
    {
        return $this->rating;
    }

    public function setRating(?int $rating): self
    {
        $this->rating = $rating;

        return $this;
    }

    /**
     * @return Collection|Game[]
     */
    public function getGames(): Collection
    {
        return $this->games;
    }

    public function addGame(Game $game): self
    {
        if (!$this->games->contains($game)) {
            $this->games[] = $game;
            $game->setOwner($this);
        }

        return $this;
    }

    public function removeGame(Game $game): self
    {
        if ($this->games->removeElement($game)) {
            // set the owning side to null (unless already changed)
            if ($game->getOwner() === $this) {
                $game->setOwner(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Operation[]
     */
    public function getOperationsAsBorrower(): Collection
    {
        return $this->operationsAsBorrower;
    }

    public function addOperationsAsBorrower(Operation $operationsAsBorrower): self
    {
        if (!$this->operationsAsBorrower->contains($operationsAsBorrower)) {
            $this->operationsAsBorrower[] = $operationsAsBorrower;
            $operationsAsBorrower->setBorrower($this);
        }

        return $this;
    }

    public function removeOperationsAsBorrower(Operation $operationsAsBorrower): self
    {
        if ($this->operationsAsBorrower->removeElement($operationsAsBorrower)) {
            // set the owning side to null (unless already changed)
            if ($operationsAsBorrower->getBorrower() === $this) {
                $operationsAsBorrower->setBorrower(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Operation[]
     */
    public function getOperationsAsLender(): Collection
    {
        return $this->operationsAsLender;
    }

    public function addOperationsAsLender(Operation $operationsAsLender): self
    {
        if (!$this->operationsAsLender->contains($operationsAsLender)) {
            $this->operationsAsLender[] = $operationsAsLender;
            $operationsAsLender->setLender($this);
        }

        return $this;
    }

    public function removeOperationsAsLender(Operation $operationsAsLender): self
    {
        if ($this->operationsAsLender->removeElement($operationsAsLender)) {
            // set the owning side to null (unless already changed)
            if ($operationsAsLender->getLender() === $this) {
                $operationsAsLender->setLender(null);
            }
        }

        return $this;
    }

    public function getProvince(): ?string
    {
        return $this->province;
    }

    public function setProvince(?string $province): self
    {
        $this->province = $province;

        return $this;
    }
}
