<?php

namespace App\Controller;

use App\Entity\Facture;
use App\Form\FactureType;
use App\Form\FactureType2;
use App\Form\FactureType3;
use App\Repository\FactureRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
 use Knp\Snappy\Pdf;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
 
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/facture')]
class FactureController extends AbstractController
{
     private $pdfService;

    public function __construct(Pdf $pdfService)
    {
        $this->pdfService = $pdfService;
    }

    public function generatePdf(Facture $facture , Request $request): Response
    {
 
        $htmlContent = $this->renderView('facture/pdf.html.twig', [
            'id' => $facture->getId()
             ,         'totale'=>$facture->getTotale()
            ,         'tva'=>$facture->getTva()
            ,         'createdat'=>$facture->getCreatedAt()
            ,'facture'=>$facture

    
    
    
    
    ]);
        
        // Générer le PDF à partir du contenu HTML
        $pdfContent = $this->pdfService->getOutputFromHtml($htmlContent);
    
        // Renvoyer le PDF en tant que réponse
        return new Response(
            $pdfContent,
            Response::HTTP_OK,
            array(
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'attachment; filename="Facture.pdf"'
            )
        );
    }
    public function downloadPdf(string $filename): Response
    {
        // Renvoyer le fichier PDF au client pour le téléchargement
        return $this->file($filename, 'document.pdf');
    }


    #[Route('/', name: 'app_facture_index', methods: ['GET'])]
    public function index(FactureRepository $factureRepository,PaginatorInterface $paginator,Request $request): Response
    {

        $user = $this->getUser();

       



        if ($this->isGranted('ROLE_ADMIN')) {
            $pagination = $paginator->paginate(

                $factureRepository->findAllOrderedByAsc(),
                $request->query->get('page', 1),
                1
            );
        return $this->render('facture/index.html.twig', [
            'factures' => $pagination  ]);
        }else{
            $pagination = $paginator->paginate(

                $factureRepository->findFacturesByClient($user),
                $request->query->get('page', 1),
                1
            );
            return $this->render('xfront_office/facture/index.html.twig', [

            'factures' => $pagination,  ]);

        }


      
 
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

            return $this->redirectToRoute('app_facture_etape2', ['id' => $facture->getId()], Response::HTTP_SEE_OTHER);
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
    public function show(Request $request,MailerInterface $mailer , Facture $facture,FactureRepository $fr , EntityManagerInterface $entityManager): Response
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






            $email = (new TemplatedEmail())
                ->from(new Address('Admin@AssureEase', 'ADMIN'))

                ->to($facture->getClient()->getUserIdentifier())
                ->subject('New Facture')
                ->htmlTemplate('email/email_facture.html.twig');
             
        try {
            $mailer->send($email);
        } catch (TransportExceptionInterface $e) {
           
        }    


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

    #[Route('/delete/{id}', name: 'app_facture_delete')]
    public function delete(Request $request, Facture $facture, EntityManagerInterface $entityManager): Response
    {
             $entityManager->remove($facture);
            $entityManager->flush();
        

        return $this->redirectToRoute('app_facture_index', [], Response::HTTP_SEE_OTHER);
    }



    #[Route('/{id}/ended/template', name: 'app_facture_show_ended')]
    public function showfacture(Request $request,FactureRepository $fr , Facture $facture, EntityManagerInterface $entityManager): Response
    {
        
 
        if ($this->isGranted('ROLE_ADMIN')) {
            return $this->render('facture/template.html.twig', [
                'facture' => $facture,
     
            ]);
         }
        else  {
            return $this->render('xfront_office/facture/show.html.twig', [
                'facture' => $facture,
               ]);
           
        }
       
 
    }
    
}
