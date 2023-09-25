<?php

namespace App\Controller\Admin;

use App\Repository\CreanceRepository;
use App\Repository\LogErreurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
   
    #[Route('/admin/payfip', name: 'admin_payfip_home')]
    public function index(CreanceRepository $creanceRepository, LogErreurRepository $logErreurRepository): Response
    {

        return $this->render('admin/home/index.html.twig', [
            'creances' => $creanceRepository->dernierPaiment(),
            'listeDesErreurs' => $logErreurRepository->findAll(),

        ]);
    }
}
