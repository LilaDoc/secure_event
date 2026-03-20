<?php

namespace App\Controller\API;
use App\Repository\EventRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

final class EventAPIController extends AbstractController
{    #[Route('/api/events', name: 'api_event_getlist', methods: ['GET'])]
    public function getEvents(EventRepository $eventRepository): Response
    {
    
        $events = $eventRepository->findPublished();
        return $this->json($events, 200, [], ['groups' => 'api_event_read']);
    }
}