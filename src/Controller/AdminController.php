<?php

namespace App\Controller;

use App\Entity\Event;
use App\Form\EventFormType;
use App\Repository\EventRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/admin')]
#[IsGranted('ROLE_ADMIN')]
class AdminController extends AbstractController
{

    #[Route('', name: 'admin_dashboard')]
    public function dashboard(EventRepository $eventRepository): Response
    {
        $events = $eventRepository->findAll();

        return $this->render('admin/dashboard.html.twig', [
            'events' => $events,
        ]);
    }

    #[Route('/event/new', name: 'admin_event_new')]
    public function newEvent(Request $request, EntityManagerInterface $em): Response
    {
        $event = new Event();
        $form = $this->createForm(EventFormType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($event);
            $em->flush();

            $this->addFlash('success', 'Événement créé avec succès !');
            return $this->redirectToRoute('admin_dashboard');
        }

        return $this->render('admin/event_form.html.twig', [
            'form' => $form,
            'titre_page' => 'Créer un événement',
        ]);
    }

    #[Route('/event/{id}/edit', name: 'admin_event_edit')]
    public function editEvent(Event $event, Request $request, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(EventFormType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            $this->addFlash('success', 'Événement modifié avec succès !');
            return $this->redirectToRoute('admin_dashboard');
        }

        return $this->render('admin/event_form.html.twig', [
            'form' => $form,
            'titre_page' => 'Modifier un événement',
        ]);
    }

    #[Route('/event/{id}/delete', name: 'admin_event_delete', methods: ['POST'])]
    public function deleteEvent(Event $event, Request $request, EntityManagerInterface $em): Response
    {

        if ($this->isCsrfTokenValid('delete-event-' . $event->getId(), $request->request->get('_token'))) {
            $em->remove($event);
            $em->flush();
            $this->addFlash('success', 'Événement supprimé.');
        } else {
            $this->addFlash('danger', 'Token invalide, suppression annulée.');
        }

        return $this->redirectToRoute('admin_dashboard');
    }
}
