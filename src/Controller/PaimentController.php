<?php

namespace App\Controller;

use App\Entity\Creance;
use App\Entity\ConfigurationPayfip;
// use App\Form\PayfipPaiementType;
// use App\Repository\CreanceRepository;
use App\Repository\ConfigurationPayfipRepository;
use App\Service\CreancesManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
// use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
// use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class PaimentController extends AbstractController
{
    
    #[Route('/payfip/paiment', name: 'paiment')]
    public function index(ConfigurationPayfipRepository $configurationPayfipRepository)
    {
        return $this->render('paiement/index.html.twig', [
            'PayFipList' => $configurationPayfipRepository->findAll(),
        ]);
    }

    #[Route('/paiement/recherche-creance/{configurationPayfip}', name: 'tentative_search')]
    public function tentative_search(ConfigurationPayfip $configurationPayfip)
    {

        return $this->render('paiement/search-creance.html.twig',[
            'configurationPayfip' => $configurationPayfip,

        ]);
    }

    #[Route('/paiement/recherche-creance-validation/{configurationPayfip}', name: 'tentative_search_validation')]
    public function tentative_search_validation(ConfigurationPayfip $configurationPayfip, CreancesManager $creancesManager, Request $request)
    {

        $reference = $request->get('reference');
        $montant = $request->get('montantEuros') . str_pad($request->get('montantCentimes'),2,'00');
        $montant = intval($montant);

        $email = $request->get('email');
        $emailDeConfirmation = $request->get('emailDeConfirmation');

       $creance = $creancesManager->checkCreance($reference, $montant, $email, $emailDeConfirmation);

       if(null !== $creance){
           return $this->redirectToRoute('paiement_recapitulatif',['creance'=>$creance->getId()]);
       }

       return $this->redirectToRoute('tentative_search',['configurationPayfip'=>$configurationPayfip->getId()]);


    }

    #[Route('/paiement/recapitulatif/{creance}', name: 'paiement_recapitulatif')]
    public function paiement_recapitulatif(Creance $creance, CreancesManager $creancesManager)
    {

        return $this->render('paiement/recapitulatif.html.twig',[
            'creance' => $creance,
            'url' => $creancesManager->makeURLPaiement($creance),
        ]);

    }
}
