<?php

namespace App\Controller;

use App\Entity\Contrat;
use App\Entity\Offre;
use App\Form\Contratreponse;
use App\Form\ContratType;
use App\Form\ContratType2;
use App\Form\ContratTypeaffectation;
use App\Form\ContratTypeEdit;
use App\Repository\ContratRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBag;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/contrat')]
class ContratController extends AbstractController
{

    #[Route('/', name: 'app_contrat_index', methods: ['GET'])]
    public function index(ContratRepository $pr, Request $request, EntityManagerInterface $entityManager): Response
    {
        $currentDate = new \DateTimeImmutable();
        $currentDate->modify('-2 months');
        $searchQuery = $request->query->get('search');
        $sort = $request->query->get('sort', 'asc');
        $contrats = $pr->nom($searchQuery,$sort);
 
        $co = []; 
        
        foreach ($contrats as $contrat) {
            
            if ($contrat->getDateFin() < $currentDate  ) {
                $engagement =$contrat->getEngagement();
                $debut =$contrat->getDateDebut();
                $fin =$contrat->getDateFin();
                if($fin){
                $contrat->setDateFin($debut->modify("+$engagement months"));
                
                $contrat->setDateDebut($fin->modify("+$engagement months"));
            }
                 $entityManager->persist($contrat);
                $entityManager->flush();

            }
        }
        
        



        if ($this->isGranted('ROLE_ADMIN')) {
            return $this->render('contrat/index.html.twig', [
                'contrats' => $contrats,
                'now' => $currentDate,
             ]);
         }
        else  {
            return $this->render('xfront_office/contrat/index.html.twig', [
                'contrats' => $contrats,
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


    #[Route('/demande/{id}', name: 'app_contrat_demande', methods: ['GET'])]
    public function expire( Contrat $contrat ): Response
    {
        

        return $this->render('contrat/demandeshow.html.twig', [
            "c"=>$contrat

        ]);
    }




    #[Route('/new/{id}', name: 'app_contrat_new')]
    public function new(Offre $offre, Request $request, EntityManagerInterface $entityManager): Response
    {
            $contrat = new Contrat();

            $form = $this->createForm(ContratType::class, $contrat);
            $form->handleRequest($request);
        $msg = '';
            if ($form->isSubmitted() && $form->isValid()) {
            $debut = $contrat->getDateDebut();
            $current = new DateTime('now') ;
                    if ($current > $debut) {
                $msg = 'La date actuelle doit etre sup a la date debut ';  
                return $this->render('xfront_office/contrat/new.html.twig', [
                    'contrat' => $contrat,
                    'form' => $form,
                    'msg' => $msg,

                ]);
                    }


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
                'msg' => $msg,

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
        $form = $this->createForm(ContratTypeEdit::class, $contrat);
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

     

    #[Route('/refuse/{id}', name: 'app_contrat_refuse', methods: ['GET', 'POST'])]
    public function refuse(Request $request, Contrat $contrat, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(Contratreponse::class, $contrat);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $formData = $form->getData();
            $monthsToRenew = $formData->getRenew(); // Assuming you have a getter for the "renew" field in your Contrat entity
     
            $contrat->setStatut(false);
            $contrat->setSent(false);
            $entityManager->flush();
 
        

            return $this->redirectToRoute('app_contrat_index', [], Response::HTTP_SEE_OTHER);
        }


        return $this->render('contrat/refuse.html.twig', [
            'contrat' => $contrat,
            'form' => $form,
        ]);

  
       
    }

   



    #[Route('/accepte/{id}', name: 'app_contrat_accepte', methods: ['GET', 'POST'])]
    public function accepte(Request $request,MailerInterface $mailer ,Contrat $contrat, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(Contratreponse::class, $contrat);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
       
            $contrat->setStatut(0);
            $contrat->setSent(true);

            $entityManager->flush();

            $user = $this->getUser();
            $email = (new TemplatedEmail())
                ->from(new Address('Admin@AssureEase', 'ADMIN'))

                ->to($contrat->getClient()->getUserIdentifier())
                ->subject('Demande contrat Assurance')
                ->htmlTemplate('email/email.html.twig') 
                ->context([
                    'titre' => $contrat->getOffre()->getTitre(),
                    'id' => $contrat->getOffre()->getId(),
                 ]);
            try {
                $mailer->send($email);
            } catch (TransportExceptionInterface $e) {
               
            }    
            return $this->redirectToRoute('app_contrat_index', [], Response::HTTP_SEE_OTHER);
        }


        return $this->render('contrat/accepte.html.twig', [
            'contrat' => $contrat,
            'form' => $form,
        ]);

  
       
    }

    #[Route('/confirme/{id}', name: 'app_contrat_confirme', methods: ['GET', 'POST'])]
    public function confirme(Request $request, Contrat $contrat, EntityManagerInterface $entityManager): Response
    {
         
        
             $contrat->setConfirmed(true);

            $entityManager->flush();
 
        

            return $this->redirectToRoute('app_contrat_index', [], Response::HTTP_SEE_OTHER);
        


        

  
       
    }

    #[Route('/{id}/new/affect', name: 'app_contrat_new_affect', methods: ['GET', 'POST'])]
    public function new_affect(  Request $request, Contrat $contrat, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ContratTypeaffectation::class, $contrat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $formData = $form->getData();
            $monthsToRenew = $formData->getRenew(); // Assuming you have a getter for the "renew" field in your Contrat entity
    
          $engagement =$contrat->getEngagement();
          $debut =$contrat->getDateDebut();
            $contrat->setDateFin($debut->modify("+$engagement months"));
            $contrat->setStatut(true);
            $entityManager->flush();

        

            return $this->redirectToRoute('app_contrat_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('contrat/nouvellement.html.twig', [
            'contrat' => $contrat,
            'form' => $form,
        ]);
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
