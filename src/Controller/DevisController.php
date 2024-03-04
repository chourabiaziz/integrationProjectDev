<?php

namespace App\Controller;

use App\Entity\Devis;
use App\Entity\Offre;
use App\Form\DevisType;
use App\Repository\DevisRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/devis')]
class DevisController extends AbstractController
{
    #[Route('/', name: 'app_devis_index', methods: ['GET'])]
    public function index(  DevisRepository $devisRepository , Request $request, PaginatorInterface $pg): Response
    {
        $pagination = $pg->paginate(

            $devisRepository->findAll(),
            $request->query->get('page', 1),
            4 //element par page
        );
       
        if ($this->isGranted('ROLE_ADMIN')) {
            return $this->render('devis/index.html.twig', [
                'devis' => $pagination ,
                
            ]);
         }
        else  {
            return $this->render('xfront_office/devis/index.html.twig', [
                'devis' => $pagination ,
            ]);
           
        }

      
    }

    #[Route('/new/offre/{id}', name: 'app_devis_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager ,  Offre $offre): Response
    {
        $devi = new Devis();
        $form = $this->createForm(DevisType::class, $devi);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $devi->setOffre($offre);
            $entityManager->persist($devi);
            $entityManager->flush();

            return $this->redirectToRoute('app_devis_index', [], Response::HTTP_SEE_OTHER);
        }

        if ($this->isGranted('ROLE_ADMIN')) {
            return $this->render('devis/new.html.twig', [
                'devi' => $devi,
                'form' => $form,
            ]);
         }
        else  {
            return $this->render('xfront_office/devis/new.html.twig', [
                'devi' => $devi,
                'form' => $form,            ]);
           
        }


       
    }

    #[Route('/{id}', name: 'app_devis_show', methods: ['GET'])]
    public function show(Devis $devi , DevisRepository $devisRepository , Request $request, PaginatorInterface $pg): Response
    {
       
       
        if ($this->isGranted('ROLE_ADMIN')) {
            return $this->render('devis/show.html.twig', [
                'devi' => $devi,
            ]);
         }
        else  {
            return $this->render('xfront_office/devis/show.html.twig', [
                'devi' => $devi,
            ]);
           
        }
    }

    #[Route('/{id}/edit', name: 'app_devis_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Devis $devi, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(DevisType::class, $devi);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_devis_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('devis/edit.html.twig', [
            'devi' => $devi,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/accepte', name: 'app_devis_accepte', methods: ['GET', 'POST'])]
    public function accepte(Request $request, Devis $devi, EntityManagerInterface $entityManager): Response
    {

            $devi->setStatut(true);
             $entityManager->flush();

         

             return $this->redirectToRoute('app_devis_index', [], Response::HTTP_SEE_OTHER);

    }
    #[Route('/{id}/refuse', name: 'app_devis_refuse', methods: ['GET', 'POST'])]
    public function refuse(Request $request, Devis $devi, EntityManagerInterface $entityManager): Response
    {

        $devi->setStatut(false);
             $entityManager->flush();

         

             return $this->redirectToRoute('app_devis_index', [], Response::HTTP_SEE_OTHER);

    }


    #[Route('/delete/{id}', name: 'app_devis_delete', methods: ['POST'])]
    public function delete(Request $request, Devis $devi, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$devi->getId(), $request->request->get('_token'))) {
            $entityManager->remove($devi);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_devis_index', [], Response::HTTP_SEE_OTHER);
    }
}
