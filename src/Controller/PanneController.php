<?php

namespace App\Controller;

use App\Entity\Panne;
use App\Form\PanneType;
use App\Repository\PanneRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/panne')]
class PanneController extends AbstractController
{
    #[Route('/', name: 'app_panne_index', methods: ['GET'])]
    public function index(PanneRepository $panneRepository): Response
    {
        return $this->render('panne/index.html.twig', [
            'pannes' => $panneRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_panne_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $panne = new Panne();
        $form = $this->createForm(PanneType::class, $panne);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($panne);
            $entityManager->flush();

            return $this->redirectToRoute('app_panne_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('panne/new.html.twig', [
            'panne' => $panne,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_panne_show', methods: ['GET'])]
    public function show(Panne $panne): Response
    {
        return $this->render('panne/show.html.twig', [
            'panne' => $panne,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_panne_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Panne $panne, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PanneType::class, $panne);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_panne_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('panne/edit.html.twig', [
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
}
