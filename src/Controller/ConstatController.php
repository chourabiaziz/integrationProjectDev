<?php

namespace App\Controller;

use App\Entity\Constat;
use App\Form\ConstatType;
use App\Repository\ConstatRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;



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
            ]);        }
       
    }



    #[Route('/new', name: 'app_constat_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager,SluggerInterface $slugger ): Response
    {
    $constat = new Constat();
    $form = $this->createForm(ConstatType::class, $constat);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $user = $this->getUser(); //utilisateur connecté
        $constat->setCreatedby($user);
 
        $imageFilename = $form->get('imageFilename')->getData();
            // so the PDF file must be processed only when a file is uploaded
            if ($imageFilename) {
                /*pour creer le nom de fichier  */
                // il va detecter originalName de  fichier
                $originalFilename = pathinfo($imageFilename->getClientOriginalName(), PATHINFO_FILENAME);
               // apres il va creer un slug de ma original name , il necessite un slugger qui est un service                
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$imageFilename->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $imageFilename->move(
                        $this->getParameter('constats_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                $constat->setImageFilename($newFilename);
               
            }

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
                'show' => $constat,
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
