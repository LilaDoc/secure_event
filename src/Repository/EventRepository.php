<?php

namespace App\Repository;

use App\Entity\Event;
use App\Entity\User;
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
            ->setParameter('now', new \DateTimeImmutable('now', new \DateTimeZone('Europe/Paris')))
            ->orderBy('e.dateDebut', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function findPublishedByUser(User $user): array
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.isPublished = :published')
            ->andWhere(':user MEMBER OF e.reservation')
            ->andWhere('e.dateDebut > :now')
            ->setParameter('published', true)
            ->setParameter('user', $user)
            ->setParameter('now', new \DateTimeImmutable('now', new \DateTimeZone('Europe/Paris')))
            ->orderBy('e.dateDebut', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
