<?php

namespace App\Controller;

use App\Entity\Panne;
use App\Entity\Atelier;
use App\Form\PanneType;
use App\Form\PanneType2;
use App\Repository\PanneRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\AtelierRepository;
use App\Service\PdfService;

use DateTime;
#[Route('/panne')]
class PanneController extends AbstractController
{
    #[Route('/', name: 'app_panne_index', methods: ['GET'])]
    public function index(PanneRepository $panneRepository): Response
    {
        if ($this->isGranted("ROLE_ADMIN")) {
            return $this->render('panne/index.html.twig', [
                'pannes' => $panneRepository->findAll(),
            ]);
        }else {
            return $this->render('panne/panne_index_client.html.twig', [
                'pannes' => $panneRepository->findAll(),
            ]);
        }

       
    }

    #[Route('/new', name: 'app_panne_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $panne = new Panne();
        $form = $this->createForm(PanneType::class, $panne);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $panne->setDate(new DateTime()
        );
            $entityManager->persist($panne);
            $entityManager->flush();

            return $this->redirectToRoute('app_panne_index', [], Response::HTTP_SEE_OTHER);
        }

       

        if ($this->isGranted("ROLE_ADMIN")) {
            return $this->render('panne/new.html.twig', [
                'panne' => $panne,
                'form' => $form,
            ]);
        }else {
            return $this->render('panne/new_client.html.twig', [
                'panne' => $panne,
                'form' => $form,
            ]);
    }}

    #[Route('/{id}', name: 'app_panne_show', methods: ['GET'])]
    public function show(Panne $panne): Response
    {
         // Vérifiez le rôle de l'utilisateur
         if ($this->isGranted("ROLE_ADMIN")) {
            // Si l'utilisateur est un admin, affichez la vue admin
            return $this->render('<panne</p>/show_admin.html.twig', [
                'panne' => $panne,
            ]);
        } else {
            // Sinon, affichez la vue client
            return $this->render('panne/show_client.html.twig', [
                'panne' => $panne,
            ]);
        }
    }

    #[Route('/{id}/edit', name: 'app_panne_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Panne $panne, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PanneType::class, $panne);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $entityManager->flush();

            return $this->redirectToRoute('app_panne_index' );
        }
        if ($this->isGranted("ROLE_ADMIN")) {
            return $this->render('panne/edit.html.twig', [
                'panne' => $panne,
                'form' => $form,
            ]);
        } else {
            return $this->render('panne/edit_client.html.twig', [
                'panne' => $panne,
                'form' => $form,
            ]);
        }
    }
    #[Route('/{id}/accepter', name: 'app_panne_accepte', methods: ['GET', 'POST'])]
    public function accepte(Request $request, Panne $panne, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PanneType2::class, $panne);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $panne->setEtat(true);
            $entityManager->flush();
            return $this->redirectToRoute('app_panne_index' );
        }

        return $this->render('panne/accepte.html.twig', [
            'panne' => $panne,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_panne_delete', methods: ['POST'])]
    public function delete(Request $request, Panne $panne, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$panne->getId(), $request->request->get('_token'))) {
            $entityManager->remove($panne);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_panne_index', [], Response::HTTP_SEE_OTHER);
    }
    
/*     #[Route('/{id}/affecter', name: 'app_panne_affecter', methods: ['POST'])]
    public function affecter(Request $request, Panne $panne, EntityManagerInterface $entityManager, AtelierRepository $atelierRepository): Response
    {
        $atelierId = $request->request->get('atelier');

        // Récupérer l'atelier depuis la base de données
        $atelier = $atelierRepository->find($atelierId);

        // Vérifier si l'atelier existe
        if (!$atelier) {
            throw $this->createNotFoundException('L\'atelier sélectionné n\'existe pas.');
        }

        // Affecter la panne à l'atelier
        $panne->setAtelier($atelier);

        // Enregistrer les modifications dans la base de données
        $entityManager->flush();

        // Redirection vers la page des pannes avec un message de succès
        $this->addFlash('success', 'La panne a été affectée à l\'atelier avec succès.');

        // Rendre le fichier Twig affecter.html.twig avec les données nécessaires
        return $this->render('panne/affecter.html.twig', [
            'panne' => $panne,
            'ateliers' => $atelierRepository->findAll(),
        ]);
        
    } */
    // Ajoutez une nouvelle route et une nouvelle méthode pour afficher la liste des ateliers disponibles
/*     #[Route('/ateliers-disponibles', name: 'app_ateliers_disponibles', methods: ['GET'])]
    public function afficherAteliersDisponibles(AtelierRepository $atelierRepository): Response
    {
        // Récupérez la liste des ateliers disponibles depuis votre repository
        $ateliersDisponibles = $atelierRepository->findAll(); // Ou utilisez une méthode spécifique pour récupérer les ateliers disponibles

        // Rendez le template Twig pour afficher la liste des ateliers disponibles
        return $this->render('atelier/ateliers_disponibles.html.twig', [
            'ateliersDisponibles' => $ateliersDisponibles,
        ]);
    } */
    #[Route('/pdf/{id}', name: 'panne.pdf')]
    public function generatePdfPanne(Panne $panne = null, PdfService $pdf) {
        $html = $this->render('panne/detail.html.twig', ['panne' => $panne]);
        $pdf->showPdfFile($html);
    }
}


