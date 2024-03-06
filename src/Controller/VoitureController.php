<?php

namespace App\Controller;

use App\Entity\Voiture;
use App\Form\VoitureType;
use App\Repository\VoitureRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper; 
use Symfony\Component\HttpFoundation\File\UploadedFile;
use App\Service\UploaderService;



#[Route('/voiture')]
class VoitureController extends AbstractController
{
    #[Route('/', name: 'app_voiture_index', methods: ['GET'])]
    public function index(VoitureRepository $voitureRepository): Response
    {
        if ($this->isGranted("ROLE_ADMIN")) {
            return $this->render('voiture/index.html.twig', [
                'voitures' => $voitureRepository->findAll(),
            ]);
        } else {
            return $this->render('voiture/voiture_index_client.html.twig', [
                'voitures' => $voitureRepository->findAll(),
            ]);
        }
    }

    #[Route('/new', name: 'app_voiture_new', methods: ['GET', 'POST'])]
    public function new(Request $request, UploaderService $uploaderService, EntityManagerInterface $entityManager, UploaderHelper $uploaderHelper): Response
    {
        $voiture = new Voiture();
        $form = $this->createForm(VoitureType::class, $voiture);
        $form->handleRequest($request);
        
    
        if ($form->isSubmitted() && $form->isValid()) {
            // Gérer le téléchargement de l'image de la carte grise
            $carteGriseFile = $form['carteGrise']->getData(); // Récupérer le fichier de l'image de la carte grise depuis le formulaire
    
        /*     if ($carteGriseFile) {
                // Utiliser la méthode "upload" pour télécharger le fichier
                $carteGriseFileName = $uploaderHelper->upload($carteGriseFile); 
                $voiture->setCarteGrise($carteGriseFileName); // Définir le nom du fichier dans l'entité Voiture
            } */
          
            if ($carteGriseFile) {
                $directory = $this->getParameter('voiture_directory');
                $voiture->setCarteGrise($uploaderService->uploadFile($carteGriseFile, $directory));
            }
    
            // Enregistrer la voiture
            $entityManager->persist($voiture);
            $entityManager->flush();
    
            return $this->redirectToRoute('app_voiture_index', [], Response::HTTP_SEE_OTHER);
        }
    
        // Afficher le formulaire avec la gestion des rôles
        if ($this->isGranted("ROLE_ADMIN")) {
            return $this->render('voiture/new.html.twig', [
                'voiture' => $voiture,
                'form' => $form->createView(),
            ]);
        } else {
            return $this->render('voiture/new_client.html.twig', [
                'voiture' => $voiture,
                'form' => $form->createView(),
            ]);
        }
    }
    
    
    
    


    #[Route('/{id}', name: 'app_voiture_show', methods: ['GET'])]
    public function show(Voiture $voiture): Response
    {
        // Vérifiez le rôle de l'utilisateur
        if ($this->isGranted("ROLE_ADMIN")) {
            // Si l'utilisateur est un admin, affichez la vue admin
            return $this->render('voiture/show_admin.html.twig', [
                'voiture' => $voiture,
            ]);
        } else {
            // Sinon, affichez la vue client
            return $this->render('voiture/show_client.html.twig', [
                'voiture' => $voiture,
            ]);
        }
    }
    

    #[Route('/{id}/edit', name: 'app_voiture_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Voiture $voiture, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(VoitureType::class, $voiture);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
    
            return $this->redirectToRoute('app_voiture_index', [], Response::HTTP_SEE_OTHER);
        }
    
        if ($this->isGranted("ROLE_ADMIN")) {
            return $this->render('voiture/edit.html.twig', [
                'voiture' => $voiture,
                'form' => $form,
            ]);
        } else {
            return $this->render('voiture/edit_client.html.twig', [
                'voiture' => $voiture,
                'form' => $form,
            ]);
        }
    }

    #[Route('/{id}', name: 'app_voiture_delete', methods: ['POST'])]
    public function delete(Request $request, Voiture $voiture, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$voiture->getId(), $request->request->get('_token'))) {
            $entityManager->remove($voiture);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_voiture_index', [], Response::HTTP_SEE_OTHER);
    }
}
