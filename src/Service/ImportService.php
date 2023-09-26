<?php

namespace App\Service;

use App\Entity\ConfigurationPayfip;
use App\Entity\Creance;
use App\Entity\Import;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use App\Repository\CreanceRepository;

class ImportService {


    private $creanceRepository;
    private $creancesManager;
    private $targetDirectory;
    private $kernel;

    public function __construct(CreanceRepository $creanceRepository, CreancesManager $creancesManager, KernelInterface $kernel, $targetDirectory)
    {
        $this->creanceRepository = $creanceRepository;
        $this->creancesManager = $creancesManager;
        $this->targetDirectory = $targetDirectory;
        $this->kernel = $kernel;

    }


    public function upload(UploadedFile $file, $nomClient, $numcli){
     
        $originalFileName = $file->getClientOriginalName();
        $extension = pathinfo($originalFileName, PATHINFO_EXTENSION);
        $format = ['csv'];
    
        if(in_array($extension, $format)) {
            $fileName = $nomClient. '-' .$numcli. '-' .uniqid(). '-'.time().'.'.$extension;
            try {
                $file->move($this->getTargetDirectory(), $fileName);
            } catch (FileException $e) {
                // ... handle exception if something happens during file upload
            }
            
            return $fileName;
        }
    }

    public function getTargetDirectory(){
        return $this->targetDirectory;
    }

    public function filePath(string $fileName){
        $kernelProjectDir = $this->kernel->getProjectDir();
        $filePath = $kernelProjectDir . '/public/uploads/doc/' . $fileName;
       
        return $filePath;
    }

    public function parseInformation(string $filePath, int $nbLigne = 10){
        //Récuperation du fichier et traitement,
        //affichage des infos en prépation de l'importation.

        $fichierScv = file_get_contents($filePath);

        $first = true;
        $headers = [];
        $infos = [];

        if($fichierScv != ''){
            $fichierScv = str_replace("\r\n", "\n", $fichierScv);

            $nouvelleLigne = explode("\n", $fichierScv);

            $nombreDeligne = 0;

            foreach ($nouvelleLigne as $ligne) {

                if($ligne === "")
                    continue;

                // $datas = explode(";", utf8_decode($ligne));
                
                if(mb_detect_encoding($ligne,'UTF-8', true) !== false ){
                    $ligne = mb_convert_encoding($ligne, 'UTF-8');
                }

                // if ($ligne === 'UTF-8') {
                //     // La chaîne est encodée en UTF-8
                //     var_dump("La chaîne est encodée en UTF-8");
                // } else {
                //     // La chaîne n'est pas encodée en UTF-8
                //     var_dump("La chaîne n'est pas encodée en UTF-8");
                // }

                $datas = explode(";" ,$ligne);   
                $datas = str_replace("-"," ", $datas);

                if($first) {
                    $first = false;
                    $headers = $datas;
                } else {
                    $infos [] = $datas;
                }

                $nombreDeligne++;
                if ($nombreDeligne > $nbLigne)
                    break;
            }
        }

        $return = [];
        $return['headers'] = $headers;
        $return['infos'] = $infos;

        return $return;

    }

    public function extraction(Import $import, ConfigurationPayfip $configurationPayfip, string $filePath){

        //Extraction des données et sauvegarde en bdd.
        $optionReference = $import->getOptionSelectRef();
        $optionMontant = $import->getOptionSelectMontant();

        $references = [];
        $entete = true;

        $creancesExisteDeja = [];

        $statut = [];
        $fichierScv = file_get_contents($filePath);
        $fichierScv = str_replace("\r\n", "\n", $fichierScv);

        $nouvelleLigne = explode("\n", $fichierScv);


        $dateImport = New \DateTime();

        foreach ($nouvelleLigne as $index => $ligne)
        {
            if($entete && $index == 0)
                continue;

            $creance = $this->creancesManager->create($configurationPayfip);
            $creance->setDateImport($dateImport);

            $datas = explode(';', $ligne);

            //verification des données du fichiers sur les colonnes selectionnées
            if(isset($datas[$optionReference]) && isset($datas[$optionMontant])) {

                $montant = (int)$datas[$optionMontant] * 100;
                $creance->setMontant($montant);

                //test si montant a 0 sinon oui erreur
                if($creance->getMontant() === 0){
                    $creance->setStatut(Creance::STATUT_IMPORT_ERREUR);
                }

                $creance->setReference($datas[$optionReference]);
                $creance->setStatut(Creance::STATUT_NONPAYER);
                $creance->setExer(date('Y'));
                $creance->setSaisie('X');
                $creance->setObjet('paiement');
                //besoin du statut pour l'affichage au moment de l'import et pour voir les listes
                $statut = $creance->getStatut();

                $creanceExisteDeja = $this->creanceRepository->findOneBy(['reference' => $creance->getReference(), 'configurationPayfip' => $configurationPayfip]);


                //la créance n'existe pas
                if(null === $creanceExisteDeja) {
                    $this->creanceRepository->save($creance, true);
                    $references [] = $creance;

                //Si il ya eu une erreur pour les montants étant === 0 lors de l'import
                //on peut réaffecter les montants correspondant aux créances déjà existantes
                } elseif($creanceExisteDeja->getMontant() === 0) {
                    $creanceExisteDeja->setMontant($montant);
                    $this->creanceRepository->save($creance, true);
                    $references [] = $creance;

                } else {
                    //log de l'erreur
                    $creancesExisteDeja[] = $creanceExisteDeja;
                }
            }
        }

        return array('references'=> $references,'referencesExisteDeja'=> $creancesExisteDeja, 'statut'=> $statut);

    }

}