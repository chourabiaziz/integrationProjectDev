<?php

namespace App\Controller;

use App\Entity\Avantage;
use App\Entity\Offre;
use App\Form\AvantageType;
use App\Repository\AvantageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/avantage')]
class AvantageController extends AbstractController
{
    #[Route('/', name: 'app_avantage_index', methods: ['GET'])]
    public function index(AvantageRepository $avantageRepository): Response
    {
        return $this->render('avantage/index.html.twig', [
            'avantages' => $avantageRepository->findAll(),
        ]);
    }

    #[Route('/new/{id}', name: 'app_avantage_new', methods: ['GET', 'POST'])]
    public function new(Request $request,Offre $offre , EntityManagerInterface $entityManager): Response
    {
        $avantage = new Avantage();
        $form = $this->createForm(AvantageType::class, $avantage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $avantage->setOffre($offre);
            $entityManager->persist($avantage);
            $entityManager->flush();

            return $this->redirectToRoute('app_offre_show', ['id' => $offre->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('avantage/new.html.twig', [
            'avantage' => $avantage,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_avantage_show', methods: ['GET'])]
    public function show(Avantage $avantage): Response
    {
        return $this->render('avantage/show.html.twig', [
            'avantage' => $avantage,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_avantage_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Avantage $avantage, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AvantageType::class, $avantage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_avantage_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('avantage/edit.html.twig', [
            'avantage' => $avantage,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_avantage_delete', methods: ['POST'])]
    public function delete(Request $request, Avantage $avantage, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$avantage->getId(), $request->request->get('_token'))) {
            $entityManager->remove($avantage);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_avantage_index', [], Response::HTTP_SEE_OTHER);
    }
}
