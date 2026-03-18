<?php

namespace App\Controller\Front;

use App\Entity\Event;
use App\Repository\EventRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

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
    public function inscription(Event $event, EntityManagerInterface $entityManager): Response
    {  
        $user = $this->getUser();

    // Vérifie si l'user est déjà inscrit
        if ($event->getReservation()->contains($user)) {
        $this->addFlash('warning', 'Vous êtes déjà inscrit à cet événement.');
        return $this->redirectToRoute('app_event_show', ['id' => $event->getId()]);
        }
        if ($event->getReservation()->count() >= $event->getCapaciteMax()) {
            $this->addFlash('warning', 'Evenement complet');
            return $this->redirectToRoute('app_event_show', ['id' => $event->getId()]);
        }

        $event->addReservation($user);
        $entityManager->flush();

        $this->addFlash('success', 'Inscription réussie !');
        return $this->redirectToRoute('app_event_show', ['id' => $event->getId()]);
    }
    #[Route('/profil/mes-evenements', name: 'app_mes_evenements', methods: ['GET'])]
    public function mesEvenements(EventRepository $eventRepository): Response
    {
        $user = $this->getUser();
        return $this->render('user/event.html.twig', [
            'events' => $eventRepository->findPublishedByUser($user)
        ]);
    }
}
