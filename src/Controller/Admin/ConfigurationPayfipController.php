<?php

namespace App\Controller\Admin;

use App\Entity\ConfigurationPayfip;
use App\Form\PayFipCreanceType;
use App\Form\PayFipGestionType;
use App\Repository\ConfigurationPayfipRepository;
// use App\Repository\LogErreurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ConfigurationPayfipController extends AbstractController
{
    #[Route('/admin/payfip/liste', name: 'admin_payfip_index')]
    public function index(ConfigurationPayfipRepository $configurationPayfipRepository): Response
    {
        return $this->render('admin/configurationPayfip/index.html.twig', [
            'ConfigurationPayfips' => $configurationPayfipRepository->findAll(),

        ]);
    }

    #[Route('/admin/payfip/nouveau-formulaire', name: 'admin_payfip_new_module')]
    public function admin_payfip_new_module(ConfigurationPayfipRepository $configurationPayfipRepository, Request $request): Response
    {
        //Ajout d'un nouveau module Payfip
        $configurationPayfip = new ConfigurationPayfip();

        //TODO demander si le fichier qui sera envoyé possède une entête (pour la v2)

        $form = $this->createForm(PayFipCreanceType::class, $configurationPayfip);

        $form->handleRequest($request);
        // $file = null;
        if($form->isSubmitted() && $form->isValid()  )
        {
            $configurationPayfipRepository->save($configurationPayfip, true);
            // $file = $form->get('file')->getData();
            
            return $this->redirectToRoute('admin_import_creance', [
                'configurationPayfip' => $configurationPayfip->getId()
        ]);

        }
       
        return $this->render('admin/configurationPayfip/add.html.twig',[
//            'numcli' => $configurationPayfip->getNumcli(),
//            'type' => $configurationPayfip->getType(),
            'form' => $form->createView()
        ]);

    }


    #[Route('/admin/payfip/{configurationPayfip}/editer', name: 'admin_payfip_edit_module')]
    public function edit(ConfigurationPayfip $configurationPayfip, ConfigurationPayfipRepository $configurationPayfipRepository, Request $request)
    {

        $form = $this->createForm(PayFipGestionType::class, $configurationPayfip);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $configurationPayfipRepository->save($configurationPayfip, true);

            return $this->redirectToRoute('admin_payfip_index');
        }

        return $this->render('admin/configurationPayfip/edit.html.twig',[
            'form'=> $form->createView(),
            'configurationPayfip' => $configurationPayfip,
        ]);
    }

    #[Route('/admin/payfip/{configurationPayfip}/supprimer', name: 'admin_payfip_delete_module')]
    public function admin_payfip_delete_module(ConfigurationPayfip $configurationPayfip): Response
    {
        //redirection vers la page de suppression d'un module payfip
        return $this->render('admin/configurationPayfip/delete.html.twig',[
            'configurationPayfip' => $configurationPayfip,
        ]);
    }

   
    #[Route('/admin/payfip/{configurationPayfip}/supprimer/comfirmation', name: 'admin_payfip_delete_module_confirmation')]
    public function admin_payfip_delete_module_confirmation(ConfigurationPayfip $configurationPayfip, ConfigurationPayfipRepository $configurationPayfipRepository): Response
    {
        $configurationPayfipRepository->remove($configurationPayfip, true);

        return $this->redirectToRoute('admin_payfip_index');
    }
}
