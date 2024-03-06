<?php

namespace App\Controller;

use App\Entity\Users;
use App\Form\UserLoginType;
use App\Form\UsersType;
use Twilio\Rest\Client;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use DateTime;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mime\Email;


#[Route('/users')]
class UsersController extends AbstractController
{
    #[Route('/', name: 'app_users_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $users = $entityManager
            ->getRepository(Users::class)
            ->findAll();

        return $this->render('users/index.html.twig', [
            'users' => $users,
        ]);
    }

    #[Route('/home', name: 'home', methods: ['GET'])]
    public function home(EntityManagerInterface $entityManager, SessionInterface $session): Response
    {
        $email = $session->get('user_email');
        $user = $entityManager
            ->getRepository(Users::class)
            ->findOneBy(['email' => $email]);
        return $this->render('users/home.html.twig', [
            'mail' => $email,
            'user' => $user,
        ]);
    }

    #[Route('/new', name: 'app_users_new', methods: ['GET', 'POST'])]
    public function new(Client  $twilioClient,Request $request, EntityManagerInterface $entityManager, SessionInterface $session): Response
    {
        $user = new Users();
        $form = $this->createForm(UsersType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setCreated(new DateTime());
            $entityManager->persist($user);
            $entityManager->flush();
            $twilioClient->messages->create(
                '+21627530503',
                array(
                    'from' => $this->getParameter('twilio_number'),
                    'body' => "Merci pour avoir creer un compte"
                )
            );
            return $this->redirectToRoute('login', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('users/new.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/login', name: 'login', methods: ['GET', 'POST'])]
    public function login(Request $request, EntityManagerInterface $entityManager, SessionInterface $session): Response
    {
        //$session->set('user_id', 0);   
        //session_destroy();
        $user = new Users();
        $form = $this->createForm(UserLoginType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $existingUser = $entityManager->getRepository(Users::class)->findOneBy([
                'email' => $user->getEmail(), // Replace with the actual field name for username
                'password' => $user->getPassword(), // Replace with the actual field name for password
            ]);

            if ($existingUser) {
                $session = $this->get('session');
                $session->set('user_id', $existingUser->getId());
                $session->set('user_nom', $existingUser->getNom());
                $session->set('user_prenom', $existingUser->getPrenom());
                $session->set('user_email', $existingUser->getEmail());
                $transport = Transport::fromDsn('smtp://ramzinehdi175@gmail.com:zpbkmhkwkbmoockg@smtp.gmail.com:587');
                $mailer = new Mailer($transport);

                $htmlBody = '
                <html>
                        <head>
                        <style>
                            body {
                               
                            }
                        </style>
                    </head>
                    <body>
                       <h1>Dear Client,</h1>
                        <p>vous vennez de vous conncter </p>
                        <p>Bonne réception</p>
                    </body>
                </html>';

                $email = (new Email())
                    ->from('ramzinehdi175@gmail.com')
                    ->to($existingUser->getEmail())
                    ->subject('Notification')
                    ->html($htmlBody);

                $mailer->send($email);
                return $this->redirectToRoute('home', [], Response::HTTP_SEE_OTHER);
            } else {
            }
        }

        return $this->renderForm('users/login.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_users_show', methods: ['GET'])]
    public function show(Users $user): Response
    {
        return $this->render('users/show.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_users_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Users $user, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(UsersType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_users_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('users/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/editfront', name: 'editfront', methods: ['GET', 'POST'])]
    public function editfront(Request $request, Users $user, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(UsersType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_users_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('users/', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_users_delete', methods: ['POST'])]
    public function delete(Request $request, Users $user, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $user->getId(), $request->request->get('_token'))) {
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_users_index', [], Response::HTTP_SEE_OTHER);
    }
}
