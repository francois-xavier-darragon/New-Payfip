<?php

namespace App\Entity;

use App\Repository\ImportRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ImportRepository::class)]
class Import
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateImport = null;

    #[ORM\Column(nullable: true)]
    private ?int $option_select_ref = null;

    #[ORM\Column(nullable: true)]
    private ?int $option_select_montant = null;

    #[ORM\ManyToOne(targetEntity: ConfigurationPayfip::class, inversedBy: 'imports')]
    private ?ConfigurationPayfip $configurationPayfip = null;

    public function __construct(ConfigurationPayfip $configurationPayfip){
        $this->configurationPayfip = $configurationPayfip;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getDateImport(): ?\DateTimeInterface
    {
        return $this->dateImport;
    }

    public function setDateImport(\DateTimeInterface $dateImport): static
    {
        $this->dateImport = $dateImport;

        return $this;
    }

    public function getOptionSelectRef(): ?int
    {
        return $this->option_select_ref;
    }

    public function setOptionSelectRef(?int $option_select_ref): static
    {
        $this->option_select_ref = $option_select_ref;

        return $this;
    }

    public function getOptionSelectMontant(): ?int
    {
        return $this->option_select_montant;
    }

    public function setOptionSelectMontant(?int $option_select_montant): static
    {
        $this->option_select_montant = $option_select_montant;

        return $this;
    }

    public function getConfigurationPayfip(): ?ConfigurationPayfip
    {
        return $this->configurationPayfip;
    }

    public function setConfigurationPayfip(?ConfigurationPayfip $configurationPayfip): static
    {
        $this->configurationPayfip = $configurationPayfip;

        return $this;
    }
}
