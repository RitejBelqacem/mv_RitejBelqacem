<?php

namespace App\Controller;

use App\Entity\Form;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Doctrine\ORM\EntityManagerInterface;

class FormController extends AbstractController
{
    #[Route('/', name: 'app_form', methods: ['GET', 'POST'])]
    public function showForm(Request $request, MailerInterface $mailer, ValidatorInterface $validator, EntityManagerInterface $entityManager): Response
    {
        $formEntity = new Form();

        if ($request->isMethod('POST')) {
            $formEntity->setNom($request->request->get('nom'));
            $formEntity->setAdresseSource($request->request->get('adresse_source'));
            $formEntity->setAdresseDestination($request->request->get('adresse_destination'));
            $formEntity->setMessage($request->request->get('message'));

            $violations = $validator->validate($formEntity);

            if (count($violations) > 0) {
                $errorMessages = [];
                foreach ($violations as $violation) {
                    $errorMessages[] = $violation->getMessage();
                }

                return $this->render('form/form.html.twig', [
                    'errors' => $errorMessages,
                ]);
            }

            try {
                $email = (new Email())
                    ->subject('Nouveau message ' . $formEntity->getNom())
                    ->from($formEntity->getAdresseSource())
                    ->to($formEntity->getAdresseDestination())
                    ->text($formEntity->getMessage());

                $mailer->send($email);

                // Persisting the form entity to the database
                $entityManager->persist($formEntity);
                $entityManager->flush();

                $this->addFlash('success', 'Email envoyé avec succès !');
            } catch (\Exception $e) {
                $this->addFlash('error', 'Une erreur est survenue lors de l\'envoi de l\'email.');
            }

            return $this->redirectToRoute('app_form');
        }

        return $this->render('form/form.html.twig', [
            'errors' => []
        ]);
    }
}
