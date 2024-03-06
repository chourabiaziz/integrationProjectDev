<?php

namespace App\Controller;

use App\Entity\Atelier;
use App\Form\Atelier1Type;
use App\Repository\AtelierRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/atelier')]
class AtelierController extends AbstractController
{
    #[Route('/', name: 'app_atelier_index', methods: ['GET'])]
    public function index(AtelierRepository $atelierRepository): Response
    {
        return $this->render('atelier/index.html.twig', [
            'ateliers' => $atelierRepository->findAll(),
        ]);
    }
   


    #[Route('/new', name: 'app_atelier_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $atelier = new Atelier();
        $form = $this->createForm(Atelier1Type::class, $atelier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($atelier);
            $entityManager->flush();

            return $this->redirectToRoute('app_atelier_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('atelier/new.html.twig', [
            'atelier' => $atelier,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_atelier_show', methods: ['GET'])]
    public function show(Atelier $atelier): Response
    {
        return $this->render('atelier/show.html.twig', [
            'atelier' => $atelier,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_atelier_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Atelier $atelier, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(Atelier1Type::class, $atelier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_atelier_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('atelier/edit.html.twig', [
            'atelier' => $atelier,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_atelier_delete', methods: ['POST'])]
    public function delete(Request $request, Atelier $atelier, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$atelier->getId(), $request->request->get('_token'))) {
            $entityManager->remove($atelier);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_atelier_index', [], Response::HTTP_SEE_OTHER);
    }
    #[Route('/search', name: 'search_ateliers', methods: ['GET'])]
    public function search1(Request $request, AtelierRepository $atelierRepository): Response
    {
        $searchTerm = $request->query->get('q');

        if ($searchTerm) {
            // Utilisez la méthode de recherche appropriée de votre repository pour filtrer les ateliers
            $ateliers = $atelierRepository->searchByNom($searchTerm);
        } else {
            // Si aucun terme de recherche n'est fourni, redirigez simplement vers la liste des ateliers
            return $this->redirectToRoute('app_atelier_index');
        }

        return $this->render('atelier/index.html.twig', [
            'ateliers' => $ateliers,
        ]);
    }
    #[Route('/search', name: 'search_ateliers', methods: ['GET'])]
    public function search(Request $request, AtelierRepository $atelierRepository): Response
    {
        $searchTerm = $request->query->get('q');

        if ($searchTerm) {
            // Utilisez la méthode de recherche appropriée de votre repository pour filtrer les ateliers
            $ateliers = $atelierRepository->searchByNom($searchTerm);
        } else {
            // Si aucun terme de recherche n'est fourni, redirigez simplement vers la liste des ateliers
            return $this->redirectToRoute('app_atelier_index');
        }

        return $this->render('atelier/index.html.twig', [
            'ateliers' => $ateliers,
        ]);
    }


}
