<?php

namespace App\DataFixtures;

use App\Entity\Event;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class EventFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $events = [
            [
                'titre' => 'CTF Web Security Challenge',
                'description' => 'Capture The Flag orienté sécurité web : injections SQL, XSS, CSRF et plus encore.',
                'dateDebut' => new \DateTimeImmutable('+1 week'),
                'capaciteMax' => 50,
                'isPublished' => true,
                'lieu' => 'Salle A - Campus Cyber',
            ],
            [
                'titre' => 'Workshop OWASP Top 10',
                'description' => 'Atelier pratique sur les 10 vulnérabilités web les plus critiques selon l\'OWASP.',
                'dateDebut' => new \DateTimeImmutable('+2 weeks'),
                'capaciteMax' => 30,
                'isPublished' => true,
                'lieu' => 'Salle B - Campus Cyber',
            ],
            [
                'titre' => 'Conférence Pentest & Red Team',
                'description' => 'Retour d\'expérience sur des missions de tests d\'intrusion en environnement entreprise.',
                'dateDebut' => new \DateTimeImmutable('+3 weeks'),
                'capaciteMax' => 100,
                'isPublished' => true,
                'lieu' => 'Amphithéâtre Principal',
            ],
            [
                'titre' => 'Initiation Cryptographie',
                'description' => 'Introduction aux concepts de chiffrement symétrique, asymétrique et hachage.',
                'dateDebut' => new \DateTimeImmutable('+1 month'),
                'capaciteMax' => 2,
                'isPublished' => false,
                'lieu' => 'Salle C - Campus Cyber',
            ],
        ];

        foreach ($events as $eventData) {
            $event = new Event();
            $event->setTitre($eventData['titre']);
            $event->setDescription($eventData['description']);
            $event->setDateDebut($eventData['dateDebut']);
            $event->setCapaciteMax($eventData['capaciteMax']);
            $event->setIsPublished($eventData['isPublished']);
            $event->setLieu($eventData['lieu']);

            $manager->persist($event);
        }

        $manager->flush();
    }
}
