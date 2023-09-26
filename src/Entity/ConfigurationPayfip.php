<?php

namespace App\Entity;

use App\Repository\ConfigurationPayfipRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ConfigurationPayfipRepository::class)]
class ConfigurationPayfip
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nom = null;

    #[ORM\Column(length: 6, nullable: true)]
    private ?string $numcli = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $type = null;

    #[ORM\Column(nullable: true)]
    private ?int $option_select_ref = null;

    #[ORM\Column(nullable: true)]
    private ?int $option_select_montant = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $statut = null;

    #[ORM\OneToMany(mappedBy: 'configurationPayFip', targetEntity: Creance::class)]
    private Collection $creances;

    #[ORM\OneToMany(mappedBy: 'configurationPayfip', targetEntity: Import::class)]
    private Collection $imports;

    public function __construct()
    {
        $this->creances = new ArrayCollection();
        $this->imports = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getNumcli(): ?string
    {
        return $this->numcli;
    }

    public function setNumcli(?string $numcli): static
    {
        $this->numcli = $numcli;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): static
    {
        $this->type = $type;

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

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(?string $statut): static
    {
        $this->statut = $statut;

        return $this;
    }

    /**
     * @return Collection<int, Creance>
     */
    public function getCreances(): Collection
    {
        return $this->creances;
    }

    public function addCreance(Creance $creance): static
    {
        if (!$this->creances->contains($creance)) {
            $this->creances->add($creance);
            $creance->setConfigurationPayFip($this);
        }

        return $this;
    }

    public function removeCreance(Creance $creance): static
    {
        if ($this->creances->removeElement($creance)) {
            // set the owning side to null (unless already changed)
            if ($creance->getConfigurationPayFip() === $this) {
                $creance->setConfigurationPayFip(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Import>
     */
    public function getImports(): Collection
    {
        return $this->imports;
    }

    public function addImport(Import $import): static
    {
        if (!$this->imports->contains($import)) {
            $this->imports->add($import);
            $import->setConfigurationPayfip($this);
        }

        return $this;
    }

    public function removeImport(Import $import): static
    {
        if ($this->imports->removeElement($import)) {
            // set the owning side to null (unless already changed)
            if ($import->getConfigurationPayfip() === $this) {
                $import->setConfigurationPayfip(null);
            }
        }

        return $this;
    }
}
