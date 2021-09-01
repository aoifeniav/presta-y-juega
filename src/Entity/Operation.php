<?php

namespace App\Entity;

use App\Repository\OperationRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OperationRepository::class)
 */
class Operation
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
    private $operationId;

    /**
     * @ORM\Column(type="date")
     */
    private $recallDate;

    /**
     * @ORM\Column(type="date")
     */
    private $dueDate;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $returnDate;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="operationsAsBorrower")
     * @ORM\JoinColumn(nullable=false)
     */
    private $borrower;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="operationsAsLender")
     * @ORM\JoinColumn(nullable=false)
     */
    private $lender;

    /**
     * @ORM\ManyToOne(targetEntity=Game::class, inversedBy="operations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $game;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOperationId(): ?int
    {
        return $this->operationId;
    }

    public function setOperationId(int $operationId): self
    {
        $this->operationId = $operationId;

        return $this;
    }

    public function getRecallDate(): ?\DateTimeInterface
    {
        return $this->recallDate;
    }

    public function setRecallDate(\DateTimeInterface $recallDate): self
    {
        $this->recallDate = $recallDate;

        return $this;
    }

    public function getDueDate(): ?\DateTimeInterface
    {
        return $this->dueDate;
    }

    public function setDueDate(\DateTimeInterface $dueDate): self
    {
        $this->dueDate = $dueDate;

        return $this;
    }

    public function getReturnDate(): ?\DateTimeInterface
    {
        return $this->returnDate;
    }

    public function setReturnDate(?\DateTimeInterface $returnDate): self
    {
        $this->returnDate = $returnDate;

        return $this;
    }

    public function getBorrower(): ?User
    {
        return $this->borrower;
    }

    public function setBorrower(?User $borrower): self
    {
        $this->borrower = $borrower;

        return $this;
    }

    public function getLender(): ?User
    {
        return $this->lender;
    }

    public function setLender(?User $lender): self
    {
        $this->lender = $lender;

        return $this;
    }

    public function getGame(): ?Game
    {
        return $this->game;
    }

    public function setGame(?Game $game): self
    {
        $this->game = $game;

        return $this;
    }
}
