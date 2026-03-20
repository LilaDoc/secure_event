<?php

namespace App\Controller\Front;

use App\Entity\Event;
use App\Repository\EventRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use App\Services\EventReservationManager;

//#[Route('/event')]
final class EventController extends AbstractController
{
    #[Route('/event', name: 'app_event_index', methods: ['GET'])]
    public function index(EventRepository $eventRepository): Response
    {
        return $this->render('event/index.html.twig', [
            'events' => $eventRepository->findPublished(),
        ]);
    }

    #[Route('/event/{id}', name: 'app_event_show', methods: ['GET'])]
    public function show(Event $event): Response
    {
        return $this->render('event/show.html.twig', [
            'event' => $event,
        ]);
    }

    #[Route('/event/{id}/inscription', name: 'app_event_inscription', methods: ['POST'])]
    public function inscription(Event $event, Request $request, EntityManagerInterface $entityManager, EventReservationManager $eventReservationManager): Response
    {
        if (!$this->isCsrfTokenValid('inscription' . $event->getId(), $request->request->get('_token'))) {
            throw $this->createAccessDeniedException('Token CSRF invalide.');
        }

        $user = $this->getUser();

        if ($eventReservationManager->isUserAlreadyRegistered($event, $user)) {
            $this->addFlash('warning', 'Vous êtes déjà inscrit à cet événement.');
            return $this->redirectToRoute('app_event_show', ['id' => $event->getId()]);
        }
        if ($eventReservationManager->isEventFull($event)) {
            $this->addFlash('warning', 'Evenement complet');
            return $this->redirectToRoute('app_event_show', ['id' => $event->getId()]);
        }

        $event->addReservation($user);
        $entityManager->flush();

        $this->addFlash('success', 'Inscription réussie !');
        return $this->redirectToRoute('app_event_show', ['id' => $event->getId()]);
    }
}
