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
use Symfony\Component\HttpFoundation\JsonResponse;
use Knp\Component\Pager\PaginatorInterface;



#[Route('/atelier')]
class AtelierController extends AbstractController
{
    #[Route('/', name: 'app_atelier_index', methods: ['GET'])]
    public function index(Request $request, AtelierRepository $atelierRepository, PaginatorInterface $paginator): Response
    {
        $searchTerm = $request->query->get('search');
        $queryBuilder = $atelierRepository->createQueryBuilder('a');
    
        if ($searchTerm) {
            $queryBuilder->where('a.nom LIKE :searchTerm')
                        ->setParameter('searchTerm', '%'.$searchTerm.'%');
        }
    
        // Récupérer les résultats de recherche ou tous les ateliers
        $ateliers = $queryBuilder->getQuery()->getResult();
    
        // Paginer les résultats
        $query = $queryBuilder->getQuery();

        // Paginer les résultats
        $ateliersPaginated = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            10
        );
    
        return $this->render('atelier/index.html.twig', [
            'ateliers' => $ateliersPaginated,
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
   


}
