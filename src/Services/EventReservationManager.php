<?php
namespace App\Services;
use app\Entity\Event;

class EventReservationManager
{
    public function isEventFull(Event $event): bool
    {
        return $event->getReservation()->count() >= $event->getCapaciteMax();
    }
    public function isUserAlreadyRegistered(Event $event, $user): bool
    {
        return $event->getReservation()->contains($user);
    }
}