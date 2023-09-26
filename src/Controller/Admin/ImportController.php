<?php

namespace App\Controller\Admin;

use App\Entity\ConfigurationPayfip;
use App\Form\ImportType;
use App\Repository\ConfigurationPayfipRepository;
use App\Service\ImportService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class ImportController extends AbstractController
{
    
    #[Route('/admin/payfip/{configurationPayfip}/import', name: 'admin_import_creance')]
    public function admin_import_creance(ConfigurationPayfip $configurationPayfip,
                              ConfigurationPayfipRepository $configurationPayfipRepository, SessionInterface $session,
                              ImportService $importService,
                              Request $request): Response
    {

        $fileName = $session->get('fileName');
        $filePath = $importService->filePath($fileName);
        $datas = $importService->parseInformation($filePath);

        $form = $this->createForm(ImportType::class, $configurationPayfip, [
            'headers' => array_flip($datas['headers']),
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() )
        {
            if($configurationPayfip->getOptionSelectRef() !== $configurationPayfip->getOptionSelectMontant()){
                $configurationPayfipRepository->save($configurationPayfip, true);

                return  $this->redirectToRoute('admin_extraction_import', [
                    'configurationPayfip' => $configurationPayfip->getId()
                ] );
            } else {
                $form->get('option_select_ref')->addError(new FormError('Valeur identique'));
                $form->get('option_select_montant')->addError(new FormError('Valeur identique'));
            }
        }

        return $this->render('admin/creance/affichage-import.html.twig',[
            'configurationPayfip' => $configurationPayfip,
            'headers'=>$datas['headers'],
            'infos'=> $datas['infos'],
            'form'=>$form->createView()
        ]);
    }

    #[Route('/admin/payfip/{configurationPayfip}/import/extration', name: 'admin_extraction_import')]
    public function admin_extraction_import(ConfigurationPayfip $configurationPayfip, ImportService $importService, SessionInterface $session)
    {
        // $filename= '../public/doc/REFERENCE TIPI.csv';
        $fileName = $session->get('fileName');
        $filePath = $importService->filePath($fileName);
        $retour = $importService->extraction($configurationPayfip, $filePath);

        return  $this->render('admin/creance/liste-import.html.twig',[
            'references' => $retour['references'],
            'referencesExisteDeja' => $retour['referencesExisteDeja'],
            'statut'=> $retour['statut'],
            'configurationPayfip' => $configurationPayfip,
        ]);
    }
}
