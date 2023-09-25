<?php

namespace App\Controller;

// use App\Repository\CreanceRepository;
use App\Service\CreancesManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
// use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
// use function dump;

class IpnRetourController extends AbstractController
{
    #[Route('/payfip/ipn/{creance_id}/', name: 'payfip_ipn_retour')]
    public function retourTest(string $creance_id, CreancesManager $creancesManager, Request $request): Response
    {
//       $test = '?numcli=019564&exer=9999&refdet=999900000000999999&objet=TEST&montant=8700&mel=support@15net.fr&urlcl=&RESULTRANS=P&NUMAUTO=XXXXXX&saisie=T';


            //recupération des retours
            $montant = $request->get('montant');
            $exer = $request->get('exer');
            $resultrans = $request->get('RESULTRANS');
            $numauto = $request->get('NUMAUTO');
            $datTrans = $request->get('DATTRANS');
            $heurTrans = $request->get('HEURTRANS');
            $idop = $request->get('IDOP');
//            $urlNotif = $request->get('URLNOTIF');
//            $urlRedirect = $request->get('URLREDIRCT');
            $url = $request->getUri();
            $creancesManager->retourIPN($creance_id,
                $montant,
                $exer,
                $resultrans,
                $numauto,
                $datTrans,
                $heurTrans,
                $idop,
                $url
            );

        return new Response();

    }


}
