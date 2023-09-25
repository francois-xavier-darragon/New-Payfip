<?php

namespace App\Entity;

use App\Repository\CreanceRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\Cascade;

#[ORM\Entity(repositoryClass: CreanceRepository::class)]
class Creance
{
    public const STATUT_NONPAYER = 0;
    public const STATUT_PAYER = 1;
    public const STATUT_REFUSER = 2;
    public const STATUT_ABANDONER = 3;
    public const STATUT_TEST = 4;
    public const STATUT_IMPORT_ERREUR = 99;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $reference = null;

    #[ORM\Column]
    private ?int $montant = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $email = null;

    #[ORM\Column(length: 4, nullable: true)]
    private ?string $exer = null;

    #[ORM\Column(length: 249, nullable: true)]
    private ?string $urlnotif = null;

    #[ORM\Column(length: 249, nullable: true)]
    private ?string $urlredirect = null;

    #[ORM\Column(length: 1, nullable: true)]
    private ?string $resultrans = null;

    #[ORM\Column(length: 16, nullable: true)]
    private ?string $numauto = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dattrans = null;

    #[ORM\Column(length: 36, nullable: true)]
    private ?string $idop = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $heurTrans = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $logErreur = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $Objet = null;

    #[ORM\Column(length: 1, nullable: true)]
    private ?string $saisie = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $referenceDenvoie = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateImport = null;

    #[ORM\Column(nullable: true)]
    private ?int $statut = null;

    #[ORM\ManyToOne(inversedBy: 'creances')]
    #[ORM\JoinColumn(nullable: false, onDelete: 'cascade')]
    private ?ConfigurationPayfip $configurationPayfip = null;
   

    public function __construct(ConfigurationPayfip $configurationPayfip)
    {
        $this->configurationPayfip = $configurationPayfip;
        $this->statut = self::STATUT_NONPAYER;
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(string $reference): static
    {
        $this->reference = $reference;

        return $this;
    }

    public function getMontant(): ?int
    {
        return $this->montant;
    }

    public function setMontant(int $montant): static
    {
        $this->montant = $montant;

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

    public function getExer(): ?string
    {
        return $this->exer;
    }

    public function setExer(?string $exer): static
    {
        $this->exer = $exer;

        return $this;
    }

    public function getUrlnotif(): ?string
    {
        return $this->urlnotif;
    }

    public function setUrlnotif(?string $urlnotif): static
    {
        $this->urlnotif = $urlnotif;

        return $this;
    }

    public function getUrlredirect(): ?string
    {
        return $this->urlredirect;
    }

    public function setUrlredirect(?string $urlredirect): static
    {
        $this->urlredirect = $urlredirect;

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

    public function getDattrans(): ?\DateTimeInterface
    {
        return $this->dattrans;
    }

    public function setDattrans(?\DateTimeInterface $dattrans): static
    {
        $this->dattrans = $dattrans;

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

    public function getHeurTrans(): ?\DateTimeInterface
    {
        return $this->heurTrans;
    }

    public function setHeurTrans(?\DateTimeInterface $heurTrans): static
    {
        $this->heurTrans = $heurTrans;

        return $this;
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

    public function getObjet(): ?string
    {
        return $this->Objet;
    }

    public function setObjet(?string $Objet): static
    {
        $this->Objet = $Objet;

        return $this;
    }

    public function getSaisie(): ?string
    {
        return $this->saisie;
    }

    public function setSaisie(?string $saisie): static
    {
        $this->saisie = $saisie;

        return $this;
    }

    public function getReferenceDenvoie(): ?string
    {
        return $this->referenceDenvoie;
    }

    public function setReferenceDenvoie(?string $referenceDenvoie): static
    {
        $this->referenceDenvoie = $referenceDenvoie;

        return $this;
    }

    public function getDateImport(): ?\DateTimeInterface
    {
        return $this->dateImport;
    }

    public function setDateImport(?\DateTimeInterface $dateImport): static
    {
        $this->dateImport = $dateImport;

        return $this;
    }

    public function getStatut(): ?int
    {
        return $this->statut;
    }

    public function setStatut(?int $statut): static
    {
        $this->statut = $statut;

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

    public function isEqualMontant(int $montant): bool
    {
        $temp = $montant;

        return ($this->montant === $temp);
    }

    public function printStatut(){
        switch ($this->statut){
            case self::STATUT_NONPAYER :
                return 'Non payée';

            case self::STATUT_PAYER :
                return 'Payée';

            case self::STATUT_REFUSER :
                return 'Refusée';

            case self::STATUT_ABANDONER :
                return 'Abandonnée';

            case self::STATUT_TEST :
                return 'Test';
        }

        return '';
    }

    function emailValide($email): bool
    {

        $regex = "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/";
        return !!preg_match($regex, $email);

    }

    public function printMontant(){
        return sprintf('%.02f',$this->montant/100).' €';
    }
}
