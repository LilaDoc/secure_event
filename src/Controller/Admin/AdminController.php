<?php

namespace App\Controller\Admin;

use App\Entity\Event;
use App\Form\EventFormType;
use App\Repository\EventRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use App\Services\EventMaxCapacityManager;


#[Route('/admin')]
#[IsGranted('ROLE_ADMIN')]
class AdminController extends AbstractController
{
    #[Route('', name: 'app_admin_dashboard')]
    public function dashboard(EventRepository $eventRepository): Response
    {
        return $this->render('admin/dashboard.html.twig', [
            'events' => $eventRepository->findAll(),
        ]);
    }

    #[Route('/event/{id}', name: 'admin_event_show', methods: ['GET'], requirements: ['id' => '\d+'])]
    public function showEvent(Event $event): Response
    {
        return $this->render('admin/event\event_show.html.twig', [
            'event' => $event,
        ]);
    }

    #[Route('/event/new', name: 'admin_event_new')]
    public function newEvent(Request $request, EntityManagerInterface $em): Response
    {
        $event = new Event();
        $form  = $this->createForm(EventFormType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($event);
            $em->flush();
            $this->addFlash('success', 'Événement créé avec succès !');
            return $this->redirectToRoute('app_admin_dashboard');
        }

        return $this->render('admin/event/event_form.html.twig', [
            'form'       => $form,
            'event'      => $event,
            'titre_page' => 'Créer un événement',
        ]);
    }

    #[Route('/event/{id}/edit', name: 'admin_event_edit', requirements: ['id' => '\d+'])]
    public function editEvent(Event $event, Request $request, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(EventFormType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            $this->addFlash('success', 'Événement modifié avec succès !');
            return $this->redirectToRoute('admin_event_show', ['id' => $event->getId()]);
        }

        return $this->render('admin/event\event_form.html.twig', [
            'form'       => $form,
            'event'      => $event,
            'titre_page' => 'Modifier l\'événement',
        ]);
    }

    #[Route('/event/{id}/delete', name: 'admin_event_delete', methods: ['POST'], requirements: ['id' => '\d+'])]
    public function deleteEvent(Event $event, Request $request, EntityManagerInterface $em): Response
    {
        if ($this->isCsrfTokenValid('delete-event-' . $event->getId(), $request->request->get('_token'))) {
            $em->remove($event);
            $em->flush();
            $this->addFlash('success', 'Événement supprimé.');
        } else {
            throw $this->createAccessDeniedException('Token CSRF invalide.');
        }

        return $this->redirectToRoute('app_admin_dashboard');
    }
    #[Route('admin/event/{id}/participants', name: 'admin_event_participants', methods: ['GET'], requirements: ['id' => '\d+'])]
    public function showEventParticipants(Event $event): Response
    {
        return $this->render('admin/event/admin_event_participants.html.twig', [
            'event' => $event,
            'participants' => $event->getReservation(),
        ]);
    }
    #[Route('admin/event/{id}/changeMaxCapacity', name: 'admin_event_change_capacity', methods: ['POST'], requirements: ['id' => '\d+'])]
    public function changeMaxCapacity(Event $event, Request $request, EntityManagerInterface $entityManager, EventMaxCapacityManager $eventMaxCapacityManager): Response
    {
        if (!$this->isCsrfTokenValid('change_capacity' . $event->getId(), $request->request->get('_token'))) {
            throw $this->createAccessDeniedException('Token CSRF invalide.');
        }

        $newCapacity = (int) $request->request->get('capaciteMax');
        if (!$eventMaxCapacityManager->isValid($event, $newCapacity)) {
            $this->addFlash('warning', 'La capacité doit être un nombre positif.');
            return $this->redirectToRoute('admin_event_show', ['id' => $event->getId()]);
        }

        if ($eventMaxCapacityManager->isLowerThanReservations($event, $newCapacity)) {
            
            $participantsToRemove = $eventMaxCapacityManager->getLastParticipantsToRemove($event, $newCapacity);
            $this->addFlash('warning', 'La nouvelle capacité est inférieure au nombre de réservations actuelles.Les participants suivants seront désinscrits : ' . implode(', ', array_map(fn($user) => $user->getUsername(), $participantsToRemove)));
            foreach ($participantsToRemove as $user) {
                $event->removeReservation($user);
                $entityManager->flush();
            }
            return $this->redirectToRoute('admin_event_participants', ['id' => $event->getId()]);

        }

        $event->setCapaciteMax($newCapacity);
        $entityManager->flush();

        $this->addFlash('success', 'Capacité maximale mise à jour avec succès !');
        return $this->redirectToRoute('admin_event_participants', ['id' => $event->getId()]);
    }
}
