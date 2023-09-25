<?php

namespace App\Controller\Admin;

// use App\Entity\Creance;
use App\Entity\ConfigurationPayfip;
// use App\Form\PayFipGestionType;
// use App\Repository\ConfigurationPayfipRepository;
// use App\Repository\CreanceRepository;
use App\Service\CreancesManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
// use Symfony\Component\HttpFoundation\Request;
// use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
// use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Twig\Token;

class TestPayFipController extends AbstractController
{
   

    #[Route('/admin/payfip/{configurationPayfip}/test', name: 'test')]
    public function test(ConfigurationPayfip $configurationPayfip, CreancesManager $creanceTestManager)
    {

        $creance = $creanceTestManager->makeTest($configurationPayfip);


        return $this->redirectToRoute('paiement_recapitulatif',[
            'creance'=>$creance->getId()]);

    }
}
