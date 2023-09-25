<?php

namespace App\Service;


use App\Entity\ConfigurationPayfip;
use App\Entity\Creance;
use App\Entity\LogErreur;
use App\Repository\CreanceRepository;
use App\Repository\LogErreurRepository;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class CreancesManager {


    /**
     * @var CreanceRepository
     */
    private $creanceRepository;
    /**
     * @var UrlGeneratorInterface
     */
    private $generator;
    /**
     * @var LogErreurRepository
     */
    private $logErreurRepository;
    /**
     * @var RequestStack
     */
    private $requestStack;


    public function __construct(CreanceRepository $creanceRepository,LogErreurRepository $logErreurRepository, RequestStack $requestStack, UrlGeneratorInterface $generator)
    {
        $this->creanceRepository = $creanceRepository;
        $this->logErreurRepository = $logErreurRepository;
        $this->generator = $generator;
        $this->requestStack = $requestStack;

    }

    public function create($configurationPayfip){
        $creance = new Creance($configurationPayfip);

        $creance->setStatut(Creance::STATUT_NONPAYER)
        ->setExer(date('Y'))
        ->setSaisie('X')
        ->setObjet('paiement');

        return $creance;
    }


    public function makeTest(ConfigurationPayfip $configurationPayfip){

        //Création dune fonction de test.
        $creance = $this->create($configurationPayfip);

        //role par dafaut
        $reference = '9999-99-99-0000000000000';

        if($configurationPayfip->getType() == 'titre'){
            $reference = '9999-00000000-999999';
        }

        $referenceFormat = str_replace("-","", $reference);
        $montant = 100;
        $email = 'support@net15.fr';

        $creance->setReference($reference)
            ->setReferencedenvoie($referenceFormat)
            ->setMontant($montant)
            ->setEmail($email)->setObjet('test')
            ->setSaisie('T')
            ->setStatut(Creance::STATUT_TEST)
            ->setDateImport(new \DateTime());


        $this->creanceRepository->save($creance, true);

        return $creance;
    }

    public function makeURLPaiement(Creance $creance): string
    {
        //Création de l'url d'envoi et ajout des champs requis.
        $url = 'https://www.tipi.budget.gouv.fr/tpa/paiement.web?';

        $numcli = $creance->getConfigurationPayfip()->getNumcli();
        $exer = date('Y');
        $reference = $creance->getReferencedenvoie();
        $objet = 'paiement';
        if($creance->getStatut() == Creance::STATUT_TEST){
            $objet = 'test';
        }

        $saisie = $creance->getSaisie();
        $montant = $creance->getMontant();
        $email = $creance->getEmail();

        $urlcl = $this->generator->generate('payfip_ipn_retour', [
            'creance_id' => $creance->getId(),
        ],UrlGeneratorInterface::ABSOLUTE_URL);


        return $url.'numcli='.$numcli.'&'.'exer='.$exer.'&'.'refdet='.$reference.'&'.'objet='.$objet.'&'.'montant='.$montant.'&'.'mel='.$email.'&'.$urlcl.'&'.'saisie='.$saisie;

    }

    public function checkCreance(string $reference, int $montant, string $email, string $emailDeConfirmation)
    {
        //Vérification de l'email et sauvegarde en bdd.
        if($email !== $emailDeConfirmation)
            return null;

        $creance = $this->creanceRepository->findOneBy(['reference'=>$reference,'montant'=>$montant]);
        $email = $creance->setEmail($email);

        $this->creanceRepository->save($email, true);

        return $creance;

    }

    public function retourIPN(int $creance_id, string $montant, string $exer, string $resultrans, string $numauto, string $dateTrans, string $heureTrans, string $idop, string $url)
    {
        //Fonction de retour ipn et insertion des données reçut en bdd
        $creance = $this->creanceRepository->find($creance_id);

        $formatDateTrans = \DateTime::createFromFormat('Y-m-d', $dateTrans);

        $formatHeurTrans = \DateTime::createFromFormat('H:i', $heureTrans);

        $email = $this->requestStack->getCurrentRequest()->query->get('mel');

        if(null === $creance){

            $logErreur = new LogErreur();
            $logErreur->setCreanceId($creance_id)
            ->setMontant($montant)
            ->setResultrans($resultrans)
            ->setHeurTrans($formatHeurTrans)
            ->setDattrans($formatDateTrans)
            ->setEmail($email)
            ->setExer($exer)
            ->setNumauto($numauto)
            ->setIDOP($idop)
            ->setLogErreur('La créance n\'a pas été trouvé.')
            ->setUrl($url);

            $this->logErreurRepository->save($logErreur, true);
                return;
        }

        //Si le montant ne correspond pas au motant de la créance
        if(!$creance->isEqualMontant((int)$montant)) {
            $creance->setLogErreur('Le montant ne correspond pas à la créance');

        } else {
        //Si tous est bon Erreur null
            $creance->setLogErreur(null);
        }


        $creance->setHeurTrans($formatHeurTrans)
        ->setDattrans($formatDateTrans)
        ->setExer($exer);
//        ->setNumauto($numauto)
//        ->setIDOP($idop);

        //test si tentative de paiement effectuer on changer le statut
        if($resultrans === 'P' || $resultrans === 'V') {
            $creance->setStatut(Creance::STATUT_PAYER);
        }elseif($resultrans ==='R' || $resultrans === 'Z') {
            $creance->setStatut(Creance::STATUT_REFUSER);
        } elseif($resultrans === 'A' ) {
            $creance->setStatut(Creance::STATUT_ABANDONER);
        }

        $creance->setResultrans($resultrans);

        $this->creanceRepository->save($creance, true);
    }

}