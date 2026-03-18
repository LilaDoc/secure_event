<?php

namespace App\Repository;

use App\Entity\Event;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Event>
 */
class EventRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Event::class);
    }

    /**
     * Retourne uniquement les événements publiés et à venir, triés par date.
     *
     * @return Event[]
     */
    public function findPublished(): array
    {
        return $this->createQueryBuilder('e')
            ->where('e.isPublished = true')
            ->andWhere('e.dateDebut > :now')
            ->setParameter('now', new \DateTimeImmutable())
            ->orderBy('e.dateDebut', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
