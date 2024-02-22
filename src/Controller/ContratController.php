<?php

namespace App\Controller;

use App\Entity\Contrat;
use App\Entity\Offre;
use App\Form\ContratType;
use App\Form\ContratType2;
use App\Repository\ContratRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBag;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;

use Symfony\Component\Routing\Attribute\Route;

#[Route('/contrat')]
class ContratController extends AbstractController
{

    #[Route('/', name: 'app_contrat_index', methods: ['GET'])]
    public function index(ContratRepository $contratRepository, Request $request, EntityManagerInterface $entityManager): Response
    {
        $currentDate = new \DateTime();


        $search = $request->query->get('search');
        $select = $request->query->get('select');
        $queryBuilder2 = $entityManager->createQueryBuilder();
        $queryBuilder2
            ->select('c')
            ->from(Contrat::class, 'c');

        if ($select === 'ref') {
            // Recherche par ID
            $queryBuilder2->andWhere('c.id = :search')
                ->setParameter('search', $search);
        } elseif ($select === 'client') {
            $queryBuilder2->andWhere("c.client LIKE :search")
                ->setParameter('search', '%' . $search . '%');
        } elseif ($select === 'assurance') {
            $queryBuilder2->andWhere("c.createdBy LIKE :search")
                ->setParameter('search', '%' . $search . '%');

        }

        $contrats_searched = $queryBuilder2->getQuery()->getResult();

        $all = $contratRepository->findAllOrderedByAsc();
        foreach ($all as $contrat) {
            if ($contrat->getDateFin() < $currentDate) {
                $contrat->setStatut(false);
                $contrat->setClient($this->getUser());
                $entityManager->persist($contrat);
            }
            $entityManager->flush();

        }



        if ($this->isGranted('ROLE_ADMIN')) {
            return $this->render('contrat/index.html.twig', [
                'contrats' => $all,
                'now' => $currentDate,
                'contrats_searched' => $contrats_searched
            ]);
         }
        else  {
            return $this->render('xfront_office/contrat/index.html.twig', [
                'contrats' => $all,
                'now' => $currentDate,
                'contrats_searched' => $contrats_searched
            ]);
           
        }
       
    }



    #[Route('/actif', name: 'app_contrat_actif', methods: ['GET'])]
    public function actif(ContratRepository $contratRepository, EntityManagerInterface $entityManagerInterface): Response
    {




        $queryBuilder = $entityManagerInterface->createQueryBuilder();

        $queryBuilder
            ->select('c')
            ->from(Contrat::class, 'c')
            ->where('c.statut = :statut')
            ->setParameter('statut', true);

        $actif = $queryBuilder->getQuery()->getResult();


        return $this->render('contrat/actif.html.twig', [
            'contrats' => $actif,


        ]);
    }


    #[Route('/expire', name: 'app_contrat_expire', methods: ['GET'])]
    public function expire(ContratRepository $contratRepository, Request $request, EntityManagerInterface $entityManagerInterface): Response
    {
        $currentDate = new \DateTime();







        $queryBuilder = $entityManagerInterface->createQueryBuilder();

        $queryBuilder
            ->select('c')
            ->from(Contrat::class, 'c')
            ->where('c.statut = :statut')
            ->setParameter('statut', false);

        $expire = $queryBuilder->getQuery()->getResult();


        return $this->render('contrat/expire.html.twig', [
            'contrats' => $expire,


        ]);
    }




    #[Route('/new/{id}', name: 'app_contrat_new')]
    public function new(Offre $offre, Request $request, EntityManagerInterface $entityManager): Response
    {
            $contrat = new Contrat();

            $form = $this->createForm(ContratType::class, $contrat);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $contrat->setStatut(false);
                $contrat->setSent(false);
                $contrat->setClient($this->getUser());
                $contrat->setOffre($offre);

                $entityManager->persist($contrat);
                $entityManager->flush();

                return $this->redirectToRoute('app_contrat_index', [], Response::HTTP_SEE_OTHER);
            }

   
            return $this->render('xfront_office/contrat/new.html.twig', [
                'contrat' => $contrat,
                'form' => $form,
            ]);
        }

 




    #[Route('/{id}', name: 'app_contrat_show', methods: ['GET'])]
    public function show(Contrat $contrat): Response
    {

        if ($this->isGranted('ROLE_ADMIN')) {
            return $this->render('contrat/show.html.twig', [
                'contrat' => $contrat,
            ]);
         }
        else  {
            return $this->render('xfront_office/contrat/show.html.twig', [
                'contrat' => $contrat,
            ]);
           
        }

       
    }

    #[Route('/{id}/edit', name: 'app_contrat_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Contrat $contrat, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ContratType::class, $contrat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_contrat_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('contrat/edit.html.twig', [
            'contrat' => $contrat,
            'form' => $form,
        ]);
    }

    
    #[Route('/envoie/{id}', name: 'app_contrat_accepte', methods: ['GET', 'POST'])]
    public function accepte(Request $request, Contrat $contrat, EntityManagerInterface $entityManager): Response
    {

        $contrat->setStatut(true);
             $entityManager->flush();

            return $this->redirectToRoute('app_contrat_index', [], Response::HTTP_SEE_OTHER);
 
       
    }



    #[Route('/{id}/renew', name: 'app_contrat_renew', methods: ['GET', 'POST'])]
    public function renew(  ContratRepository $contratRepository, Request $request, Contrat $contrat, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ContratType2::class, $contrat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $formData = $form->getData();
            $monthsToRenew = $formData->getRenew(); // Assuming you have a getter for the "renew" field in your Contrat entity
    
            // Calculate new start and end dates
            $newStartDate = $contrat->getDateDebut()->add(new \DateInterval("P{$monthsToRenew}M"));
            $newEndDate = $contrat->getDateFin()->add(new \DateInterval("P{$monthsToRenew}M"));
    
            // Set new dates
            $contrat->setDateDebut($newStartDate);
            $contrat->setDateFin($newEndDate);
            $contrat->setStatut(true);
            $entityManager->flush();

        

            return $this->redirectToRoute('app_contrat_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('contrat/renouvellement.html.twig', [
            'contrat' => $contrat,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_contrat_delete', methods: ['POST'])]
    public function delete(Request $request, Contrat $contrat, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$contrat->getId(), $request->request->get('_token'))) {
            $entityManager->remove($contrat);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_contrat_index', [], Response::HTTP_SEE_OTHER);
    }
}
