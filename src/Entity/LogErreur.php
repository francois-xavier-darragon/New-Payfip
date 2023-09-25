<?php

namespace App\Entity;

use App\Repository\LogErreurRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LogErreurRepository::class)]
class LogErreur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $logErreur = null;

    #[ORM\Column(length: 4, nullable: true)]
    private ?string $exer = null;

    #[ORM\Column(length: 1, nullable: true)]
    private ?string $resultrans = null;

    #[ORM\Column(length: 16, nullable: true)]
    private ?string $numauto = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $datTrans = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $heurTrans = null;

    #[ORM\Column(nullable: true)]
    private ?int $montant = null;

    #[ORM\Column(length: 36, nullable: true)]
    private ?string $idop = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $url = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $email = null;

    #[ORM\Column(nullable: true)]
    private ?int $creance_id = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLogErreur(): ?string
    {
        return $this->logErreur;
    }

    public function setLogErreur(?string $logErreur): static
    {
        $this->logErreur = $logErreur;

        return $this;
    }

    public function getExer(): ?string
    {
        return $this->exer;
    }

    public function setExer(?string $exer): static
    {
        $this->exer = $exer;

        return $this;
    }

    public function getResultrans(): ?string
    {
        return $this->resultrans;
    }

    public function setResultrans(?string $resultrans): static
    {
        $this->resultrans = $resultrans;

        return $this;
    }

    public function getNumauto(): ?string
    {
        return $this->numauto;
    }

    public function setNumauto(?string $numauto): static
    {
        $this->numauto = $numauto;

        return $this;
    }

    public function getDatTrans(): ?\DateTimeInterface
    {
        return $this->datTrans;
    }

    public function setDatTrans(?\DateTimeInterface $datTrans): static
    {
        $this->datTrans = $datTrans;

        return $this;
    }

    public function getHeurTrans(): ?\DateTimeInterface
    {
        return $this->heurTrans;
    }

    public function setHeurTrans(?\DateTimeInterface $heurTrans): static
    {
        $this->heurTrans = $heurTrans;

        return $this;
    }

    public function getMontant(): ?int
    {
        return $this->montant;
    }

    public function setMontant(?int $montant): static
    {
        $this->montant = $montant;

        return $this;
    }

    public function getIdop(): ?string
    {
        return $this->idop;
    }

    public function setIdop(?string $idop): static
    {
        $this->idop = $idop;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(?string $url): static
    {
        $this->url = $url;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getCreanceId(): ?int
    {
        return $this->creance_id;
    }

    public function setCreanceId(?int $creance_id): static
    {
        $this->creance_id = $creance_id;

        return $this;
    }
}
