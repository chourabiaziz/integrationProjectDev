<?php

namespace App\Controller;

use App\Entity\Constat;
use App\Form\ConstatType;
use App\Repository\ConstatRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use App\Service\UploaderService;
use App\Service\PdfService;





#[Route('/constat')]
class ConstatController extends AbstractController
{
    #[Route('/', name: 'app_constat_index', methods: ['GET'])]
    public function index(ConstatRepository $constatRepository): Response
    {
        $user = $this->getUser(); //utilisateur connecté

        if ($this->isGranted("ROLE_ADMIN")) {
            return $this->render('constat/index.html.twig', [
                'constats' => $constatRepository->findAll(),
            ]);
        }else {
            return $this->render('xfront_office/constat/index_front.html.twig', [
                'constats' => $constatRepository->findAll(),
            ]);       
         }
       
    }

    public function generatePdfConstat(int $id, PdfService $pdf, ConstatRepository $constatRepository) {
        $constat = $constatRepository->find($id);
    
        if (!$constat) {
            throw $this->createNotFoundException('Constat not found');
        }
    
        $html = $this->render('Constat/show.html.twig', ['constat' => $constat]);
        $pdf->showPdfFile($html);
    }


    #[Route('/new', name: 'app_constat_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager,SluggerInterface $slugger ,UploaderService $uploaderService): Response
    {
    $constat = new Constat();
    $form = $this->createForm(ConstatType::class, $constat);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        
        $user = $this->getUser(); //utilisateur connecté
        $constat->setCreatedby($user);
 
      /*  $photo = $form->get('photo')->getData();
        if ($photo) {
            $directory = $this->getParameter('constats_directory');
            $constat->setImage($uploaderService->uploadFile($photo, $directory));
        }   */        

            $entityManager->persist($constat);
            $entityManager->flush();
 
        return $this->redirectToRoute('app_constat_index', [], Response::HTTP_SEE_OTHER);
    }

    return $this->render('constat/new.html.twig', [
        'constat' => $constat,
        'form' => $form->createView(),
    ]);
}


    #[Route('/{id}', name: 'app_constat_show', methods: ['GET'])]
    public function show(Constat $constat): Response
    {
        if ($this->isGranted("ROLE_ADMIN")) {
            return $this->render('constat/show.html.twig', [
                'constat' => $constat,
            ]);
        } else {
            return $this->render('constat/showClient.html.twig', [
                'constat' => $constat,
            ]);
        }
    }

   
    #[Route('/{id}/edit', name: 'app_constat_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Constat $constat, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ConstatType::class, $constat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_constat_index', [], Response::HTTP_SEE_OTHER);
        }

        if ($this->isGranted("ROLE_ADMIN")) {
            return $this->render('constat/edit.html.twig', [
                'constat' => $constat,
                'form' => $form,
            ]);
        } else {
            return $this->render('constat/editClient.html.twig', [
                'constat' => $constat,
                'form' => $form,
            ]);
        }
    
    }
    
    
    

    #[Route('/{id}', name: 'app_constat_delete', methods: ['POST'])]
    public function delete(Request $request, Constat $constat, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$constat->getId(), $request->request->get('_token'))) {
            $entityManager->remove($constat);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_constat_index', [], Response::HTTP_SEE_OTHER);
    }


  




}
