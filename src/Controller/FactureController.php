<?php

namespace App\Controller;

use App\Entity\Facture;
use App\Form\FactureType;
use App\Form\FactureType2;
use App\Form\FactureType3;
use App\Repository\FactureRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/facture')]
class FactureController extends AbstractController
{
    #[Route('/', name: 'app_facture_index', methods: ['GET'])]
    public function index(FactureRepository $factureRepository): Response
    {
        return $this->render('facture/index.html.twig', [
            'factures' => $factureRepository->findAllOrderedByAsc(),
        ]);
    }

    #[Route('/new', name: 'app_facture_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $facture = new Facture();
        $form = $this->createForm(FactureType::class, $facture);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($facture);
            $entityManager->flush();

            return $this->redirectToRoute('app_facture_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('facture/new.html.twig', [
            'facture' => $facture,
            'form' => $form,
        ]);
    }


    #[Route('/etape2/{id}', name: 'app_facture_etape2', methods: ['GET', 'POST'])]
    public function etape2(Request $request, Facture $facture, EntityManagerInterface $entityManager): Response
    {

         $form = $this->createForm(FactureType2::class, $facture,['clientName' => $facture->getClient()] );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $facture->setStatut(false);
            $entityManager->flush();

            return new RedirectResponse($this->generateUrl('app_facture_etape3', ['id' => $facture->getId()]));
        }

        return $this->render('facture/etape2.html.twig', [
            'facture' => $facture,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_facture_etape3')]
    public function show(Request $request, Facture $facture,FactureRepository $fr , EntityManagerInterface $entityManager): Response
    {
        $date = new \DateTime('now');
        $form = $this->createForm(FactureType3::class, $facture);
        $form->handleRequest($request);
        $id_fac = $facture->getId();

        $total = $fr->createQueryBuilder('i')
        ->select('SUM(c.prix) as total')
        ->leftJoin('i.contrat', 'c')
        ->where('i.id = :invoiceId')
        ->setParameter('invoiceId', $id_fac)
        ->getQuery()
        ->getSingleScalarResult();
        if ($form->isSubmitted() && $form->isValid()) {
            $facture->setCreatedAt($date);
            $facture->setStatut(true);
       

        $facture->setTotale(($total + ($total*$facture->getTva())/100 ));
 
            $entityManager->flush();

            return $this->redirectToRoute('app_facture_index', [], Response::HTTP_SEE_OTHER);
        }



        return $this->render('facture/show.html.twig', [
            'facture' => $facture,
            'form' => $form,

        ]);
    }

    #[Route('/{id}/edit', name: 'app_facture_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Facture $facture, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(FactureType::class, $facture);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_facture_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('facture/edit.html.twig', [
            'facture' => $facture,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_facture_delete', methods: ['POST'])]
    public function delete(Request $request, Facture $facture, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$facture->getId(), $request->request->get('_token'))) {
            $entityManager->remove($facture);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_facture_index', [], Response::HTTP_SEE_OTHER);
    }



    #[Route('/{id}/ended', name: 'app_facture_show')]
    public function showfacture(Request $request,FactureRepository $fr , Facture $facture, EntityManagerInterface $entityManager): Response
    {
        
 

        return $this->render('facture/template.html.twig', [
            'facture' => $facture,
 
        ]);
    }
    
}
