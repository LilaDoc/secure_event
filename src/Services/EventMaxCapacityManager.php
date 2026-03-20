<?php

namespace App\Services;

use App\Entity\Event;

class MaxCapacityManager
{
    public function isValid(Event $event, int $newCapacity): bool
    {
        // On check que le nouveau nombre de capacité max est supérieur à 0
        return $newCapacity > 0;
    }

    public function isLowerThanReservations(Event $event, int $newCapacity): bool
    {
        // On check que le nouveau nombre de capacité max est supérieur ou égal au nombre de réservations actuelles
        return $newCapacity >= $event->getReservation()->count();
    }
    public function getLastParticipantsToRemove(Event $event, int $newCapacity): array
    {
        // Si la nouvelle capacité est inférieure au nombre de réservations, on doit identifier les participants à retirer
        if ($newCapacity < $event->getReservation()->count()) {
            $participants = $event->getReservation()->toArray();
            // On retourne les participants à retirer (les derniers inscrits)
            return array_slice($participants, $newCapacity);
        }
        return [];
    }
    
}