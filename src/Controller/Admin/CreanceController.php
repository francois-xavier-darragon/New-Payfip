<?php

namespace App\Controller\Admin;

use App\Entity\ConfigurationPayfip;
use App\Entity\Creance;
use App\Repository\CreanceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CreanceController extends AbstractController
{
    
   
    #[Route('/admin/payfip/creance/liste/{configurationPayfip}/{statut}', name: 'admin_creance_liste')]
    public function admin_creance_liste(ConfigurationPayfip $configurationPayfip, CreanceRepository $creanceRepository, int $statut = 1): Response
    {
        if($statut == 5){
            $creance = $creanceRepository->findBy(['statut'=>Creance::STATUT_NONPAYER,'configurationPayfip'=>$configurationPayfip],['dateImport'=>'DESC']);
        } elseif($statut == 6) {
            $creance = $creanceRepository->findBy(['statut'=>Creance::STATUT_PAYER,'configurationPayfip'=>$configurationPayfip],['dattrans'=>'DESC','heurTrans'=>'DESC']);
        } else {
            $creance = $creanceRepository->findBy(['statut'=>$statut,'configurationPayfip'=>$configurationPayfip]);
        }

        return $this->render('admin/creance/liste.html.twig',[
            'creances'=> $creance,
            'configurationPayfip' => $configurationPayfip,
            'statut' => $statut
        ]);
    }

    
    #[Route('/admin/payfip/creance/supprimer/{creance}/{statut}', name: 'admin_remove_creance')]
    public function admin_remove_creance(Creance $creance, int $statut, CreanceRepository $creanceRepository): Response
    {

        $configurationPayfip = $creance->getConfigurationPayfip();

        $creanceRepository->remove($creance, true);

        return $this->redirectToRoute('admin_creance_liste',[
            'configurationPayfip'=> $configurationPayfip->getId(),
            'statut' => $statut

        ]);
    }


    #[Route('/admin/payfip/creance/supprimer-liste/{configurationPayfip}/{statut}', name: 'admin_remove_creance_liste')]
    public function admin_remove_creance_liste(ConfigurationPayfip $configurationPayfip, CreanceRepository $creanceRepository, int $statut =0): Response
    {

        $creanceBdd = $creanceRepository->findBy(['configurationPayfip' => $configurationPayfip, 'statut' => $statut ]);


        foreach ($creanceBdd as $creance) {
            $creanceRepository->remove($creance, true);
        }


        return $this->redirectToRoute('admin_creance_liste',[
            'configurationPayfip'=> $configurationPayfip->getId(),
            'statut' => $statut
        ]);
    }

}
