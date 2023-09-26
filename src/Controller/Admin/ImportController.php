<?php

namespace App\Controller\Admin;

use App\Entity\ConfigurationPayfip;
use App\Entity\Import;
use App\Form\ImportType;
use App\Repository\ImportRepository;
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
    public function admin_import_creance(ConfigurationPayfip $configurationPayfip, ImportRepository $importRepository, SessionInterface $session, ImportService $importService, Request $request): Response
    {
        $import = new Import($configurationPayfip);

        $fileName = $session->get('fileName');
        $filePath = $importService->filePath($fileName);
        $datas = $importService->parseInformation($filePath);

        $form = $this->createForm(ImportType::class, $import, [
            'headers' => array_flip($datas['headers']),
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

            $dateImport = New \DateTime();
            $import->setDateImport($dateImport);
            $import->SetNom($fileName);
            if($import->getOptionSelectRef() !== $import->getOptionSelectMontant()){

                $importRepository->save($import, true);
                return  $this->redirectToRoute('admin_extraction_import', [
                    'import' => $import->getId()
                ] );
            } else {
                $form->get('option_select_ref')->addError(new FormError('Valeur identique'));
                $form->get('option_select_montant')->addError(new FormError('Valeur identique'));
            }
        }

        return $this->render('admin/creance/affichage-import.html.twig',[
            'configurationPayfip' => $import,
            'headers'=>$datas['headers'],
            'infos'=> $datas['infos'],
            'form'=>$form->createView()
        ]);
    }

    #[Route('/admin/payfip/import/{import}/extration', name: 'admin_extraction_import')]
    public function admin_extraction_import(Import $import, ImportService $importService, SessionInterface $session)
    {
        
        $fileName = $session->get('fileName');
        $filePath = $importService->filePath($fileName);
        $retour = $importService->extraction($import, $import->getConfigurationPayfip(), $filePath);

        return  $this->render('admin/creance/liste-import.html.twig',[
            'references' => $retour['references'],
            'referencesExisteDeja' => $retour['referencesExisteDeja'],
            'statut'=> $retour['statut'],
            'configurationPayfip' => $import,
        ]);
    }
}
