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
         * @return Event[] Returns an array of Event objects
         */
        public function findPublished(): array
            {
             return $this->createQueryBuilder('e')
                ->andWhere('e.isPublished = :published')
                ->setParameter('published', true)
                ->orderBy('e.dateDebut', 'ASC')
                ->getQuery()
                ->getResult();
            }

    //    public function findOneBySomeField($value): ?Event
    //    {
    //        return $this->createQueryBuilder('e')
    //            ->andWhere('e.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
