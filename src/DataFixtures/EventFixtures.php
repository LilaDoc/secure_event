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
            // ── CTF ──
            [
                'titre'       => 'CTF Web Security Challenge',
                'description' => 'Capture The Flag orienté sécurité web : injections SQL, XSS, CSRF et plus encore.',
                'dateDebut'   => new \DateTimeImmutable('+3 days'),
                'capaciteMax' => 50,
                'isPublished' => true,
                'lieu'        => 'Salle A — Campus Cyber, Paris',
            ],
            [
                'titre'       => 'CTF Réseau & Infrastructure',
                'description' => 'Challenges axés sur l\'analyse réseau, le sniffing et les attaques d\'infrastructure.',
                'dateDebut'   => new \DateTimeImmutable('+5 days'),
                'capaciteMax' => 40,
                'isPublished' => true,
                'lieu'        => 'Salle B — Campus Cyber, Paris',
            ],
            [
                'titre'       => 'CTF Reverse Engineering',
                'description' => 'Décompilation de binaires, analyse de malwares et crackmes pour tous niveaux.',
                'dateDebut'   => new \DateTimeImmutable('+10 days'),
                'capaciteMax' => 30,
                'isPublished' => true,
                'lieu'        => 'Lab Informatique — ESDI, Paris',
            ],
            [
                'titre'       => 'CTF Cryptographie Avancée',
                'description' => 'Challenges de cryptanalyse : RSA, AES, courbes elliptiques et protocoles cassés.',
                'dateDebut'   => new \DateTimeImmutable('+14 days'),
                'capaciteMax' => 25,
                'isPublished' => true,
                'lieu'        => 'Salle Crypto — Télécom Paris',
            ],
            [
                'titre'       => 'CTF Forensique Numérique',
                'description' => 'Analyse de dumps mémoire, images disque et artefacts Windows/Linux.',
                'dateDebut'   => new \DateTimeImmutable('+18 days'),
                'capaciteMax' => 35,
                'isPublished' => true,
                'lieu'        => 'Salle Forensic — ANSSI, Paris',
            ],
            [
                'titre'       => 'CTF Hack The Box Live',
                'description' => 'Session Hack The Box en présentiel avec coaching d\'experts en live.',
                'dateDebut'   => new \DateTimeImmutable('+21 days'),
                'capaciteMax' => 60,
                'isPublished' => true,
                'lieu'        => 'Espace Coworking CyberHub, Lyon',
            ],
            [
                'titre'       => 'CTF Mobile Security',
                'description' => 'Reverse d\'APK Android, bypass de certificat et analyse dynamique d\'applications mobiles.',
                'dateDebut'   => new \DateTimeImmutable('+25 days'),
                'capaciteMax' => 20,
                'isPublished' => true,
                'lieu'        => 'Salle Mobile — Campus Numérique, Bordeaux',
            ],
            [
                'titre'       => 'CTF Open Source Intelligence',
                'description' => 'Challenges OSINT : recherche d\'informations, géolocalisation et profilage passif.',
                'dateDebut'   => new \DateTimeImmutable('+30 days'),
                'capaciteMax' => 45,
                'isPublished' => true,
                'lieu'        => 'Salle C — Campus Cyber, Paris',
            ],
            [
                'titre'       => 'CTF Débutants — Initiation Hacking',
                'description' => 'Parcours guidé pour les novices : premières vulnérabilités, outils de base et méthodologie.',
                'dateDebut'   => new \DateTimeImmutable('+35 days'),
                'capaciteMax' => 80,
                'isPublished' => true,
                'lieu'        => 'Amphithéâtre — École 42, Paris',
            ],
            [
                'titre'       => 'CTF Hardware & IoT',
                'description' => 'Attaques sur firmware, UART, JTAG et protocoles radio (BLE, Zigbee).',
                'dateDebut'   => new \DateTimeImmutable('+40 days'),
                'capaciteMax' => 20,
                'isPublished' => false,
                'lieu'        => 'Lab Hardware — CentraleSupélec, Gif-sur-Yvette',
            ],

            // ── WORKSHOPS ──
            [
                'titre'       => 'Workshop OWASP Top 10',
                'description' => 'Atelier pratique sur les 10 vulnérabilités web les plus critiques selon l\'OWASP.',
                'dateDebut'   => new \DateTimeImmutable('+7 days'),
                'capaciteMax' => 30,
                'isPublished' => true,
                'lieu'        => 'Salle Formation — Epitech, Paris',
            ],
            [
                'titre'       => 'Workshop Pentest Web avec Burp Suite',
                'description' => 'Prise en main avancée de Burp Suite Pro pour intercepter, modifier et rejouer des requêtes HTTP.',
                'dateDebut'   => new \DateTimeImmutable('+12 days'),
                'capaciteMax' => 25,
                'isPublished' => true,
                'lieu'        => 'Salle A — CyberCampus, Paris',
            ],
            [
                'titre'       => 'Workshop Metasploit Framework',
                'description' => 'Exploitation de vulnérabilités avec Metasploit : modules, payloads et post-exploitation.',
                'dateDebut'   => new \DateTimeImmutable('+16 days'),
                'capaciteMax' => 20,
                'isPublished' => true,
                'lieu'        => 'Lab Sécurité — ISEP, Paris',
            ],
            [
                'titre'       => 'Workshop Active Directory Attacks',
                'description' => 'Kerberoasting, Pass-the-Hash, DCSync et techniques d\'escalade de privilèges AD.',
                'dateDebut'   => new \DateTimeImmutable('+22 days'),
                'capaciteMax' => 18,
                'isPublished' => true,
                'lieu'        => 'Salle Windows — Campus Cyber, Paris',
            ],
            [
                'titre'       => 'Workshop Docker & Kubernetes Security',
                'description' => 'Sécurisation des conteneurs, escape de sandbox et audit d\'images Docker.',
                'dateDebut'   => new \DateTimeImmutable('+28 days'),
                'capaciteMax' => 25,
                'isPublished' => true,
                'lieu'        => 'Salle DevOps — Station F, Paris',
            ],
            [
                'titre'       => 'Workshop Threat Hunting',
                'description' => 'Détection proactive des menaces avec Splunk, Elastic SIEM et règles Sigma.',
                'dateDebut'   => new \DateTimeImmutable('+33 days'),
                'capaciteMax' => 22,
                'isPublished' => true,
                'lieu'        => 'SOC Lab — Thales, La Défense',
            ],
            [
                'titre'       => 'Workshop Python pour Hackers',
                'description' => 'Développement d\'outils offensifs en Python : scanners, fuzzers et exploits maison.',
                'dateDebut'   => new \DateTimeImmutable('+38 days'),
                'capaciteMax' => 30,
                'isPublished' => true,
                'lieu'        => 'Salle Dev — 42 Lyon',
            ],
            [
                'titre'       => 'Workshop Sécurité API REST',
                'description' => 'Audit d\'API : IDOR, mass assignment, broken authentication et JWT attacks.',
                'dateDebut'   => new \DateTimeImmutable('+45 days'),
                'capaciteMax' => 28,
                'isPublished' => true,
                'lieu'        => 'Salle API — Hub France IA, Paris',
            ],
            [
                'titre'       => 'Workshop Malware Analysis',
                'description' => 'Analyse statique et dynamique de malwares Windows avec Ghidra et Any.run.',
                'dateDebut'   => new \DateTimeImmutable('+50 days'),
                'capaciteMax' => 15,
                'isPublished' => false,
                'lieu'        => 'Lab Malware — CERT-FR, Paris',
            ],
            [
                'titre'       => 'Workshop Cloud Security AWS',
                'description' => 'Misconfiguration S3, IAM privilege escalation et détection d\'incidents sur AWS.',
                'dateDebut'   => new \DateTimeImmutable('+55 days'),
                'capaciteMax' => 30,
                'isPublished' => true,
                'lieu'        => 'Salle Cloud — AWS Loft, Paris',
            ],

            // ── CONFÉRENCES ──
            [
                'titre'       => 'Conférence Pentest & Red Team',
                'description' => 'Retour d\'expérience sur des missions de tests d\'intrusion en environnement entreprise.',
                'dateDebut'   => new \DateTimeImmutable('+6 days'),
                'capaciteMax' => 100,
                'isPublished' => true,
                'lieu'        => 'Amphithéâtre Principal — ESDI, Paris',
            ],
            [
                'titre'       => 'Conférence Zero Trust Architecture',
                'description' => 'Principes du Zero Trust, micro-segmentation et déploiement dans les grands groupes.',
                'dateDebut'   => new \DateTimeImmutable('+9 days'),
                'capaciteMax' => 120,
                'isPublished' => true,
                'lieu'        => 'Palais des Congrès, Paris',
            ],
            [
                'titre'       => 'Conférence Threat Intelligence',
                'description' => 'Collecte et exploitation des renseignements sur les menaces cyber avancées (APT).',
                'dateDebut'   => new \DateTimeImmutable('+13 days'),
                'capaciteMax' => 80,
                'isPublished' => true,
                'lieu'        => 'Centre de Conférences — Airbus, Toulouse',
            ],
            [
                'titre'       => 'Conférence RGPD & Cyber',
                'description' => 'Obligations légales RGPD après une violation de données, notification CNIL et PCA.',
                'dateDebut'   => new \DateTimeImmutable('+17 days'),
                'capaciteMax' => 90,
                'isPublished' => true,
                'lieu'        => 'Maison du Barreau, Paris',
            ],
            [
                'titre'       => 'Conférence Ransomware — État de l\'Art',
                'description' => 'Anatomie des groupes RaaS, chaîne d\'infection et stratégies de réponse à incident.',
                'dateDebut'   => new \DateTimeImmutable('+20 days'),
                'capaciteMax' => 150,
                'isPublished' => true,
                'lieu'        => 'Grande Salle — Cité des Sciences, Paris',
            ],
            [
                'titre'       => 'Conférence Sécurité des Systèmes Industriels',
                'description' => 'Sécurisation des environnements SCADA, ICS et OT dans les infrastructures critiques.',
                'dateDebut'   => new \DateTimeImmutable('+26 days'),
                'capaciteMax' => 70,
                'isPublished' => true,
                'lieu'        => 'Centre de Conférences EDF, Paris',
            ],
            [
                'titre'       => 'Conférence IA & Cybersécurité',
                'description' => 'Utilisation de l\'IA pour la détection d\'anomalies, l\'automatisation des attaques et la défense.',
                'dateDebut'   => new \DateTimeImmutable('+31 days'),
                'capaciteMax' => 200,
                'isPublished' => true,
                'lieu'        => 'Auditorium — Sorbonne Université, Paris',
            ],
            [
                'titre'       => 'Conférence Bug Bounty — Retours d\'Expérience',
                'description' => 'Hunters réputés partagent leurs découvertes critiques et méthodologies sur les programmes publics.',
                'dateDebut'   => new \DateTimeImmutable('+36 days'),
                'capaciteMax' => 100,
                'isPublished' => true,
                'lieu'        => 'Salle Plénière — Paris Web, Paris',
            ],
            [
                'titre'       => 'Conférence Sécurité Blockchain',
                'description' => 'Attaques sur smart contracts, audits Solidity et incidents DeFi marquants.',
                'dateDebut'   => new \DateTimeImmutable('+42 days'),
                'capaciteMax' => 60,
                'isPublished' => true,
                'lieu'        => 'Crypto Valley Hub, Paris',
            ],
            [
                'titre'       => 'Conférence OSCP & Certifications Offensives',
                'description' => 'Préparation aux certifications OSCP, CEH, GPEN : conseils, ressources et retours d\'exam.',
                'dateDebut'   => new \DateTimeImmutable('+48 days'),
                'capaciteMax' => 75,
                'isPublished' => true,
                'lieu'        => 'Salle Conférence — ESIEA, Paris',
            ],
            [
                'titre'       => 'Conférence Phishing & Ingénierie Sociale',
                'description' => 'Techniques de spear phishing, vishing, deepfakes vocaux et contre-mesures.',
                'dateDebut'   => new \DateTimeImmutable('+53 days'),
                'capaciteMax' => 110,
                'isPublished' => true,
                'lieu'        => 'Centre de Conférences Orange Cyberdefense, Nantes',
            ],

            // ── FORMATIONS ──
            [
                'titre'       => 'Formation Initiation Cryptographie',
                'description' => 'Introduction aux concepts de chiffrement symétrique, asymétrique et hachage.',
                'dateDebut'   => new \DateTimeImmutable('+4 days'),
                'capaciteMax' => 35,
                'isPublished' => true,
                'lieu'        => 'Salle C — Campus Cyber, Paris',
            ],
            [
                'titre'       => 'Formation Sécurité Linux',
                'description' => 'Durcissement d\'un système Linux : permissions, auditd, AppArmor, SELinux et SSH.',
                'dateDebut'   => new \DateTimeImmutable('+11 days'),
                'capaciteMax' => 25,
                'isPublished' => true,
                'lieu'        => 'Salle Linux — IUT Informatique, Grenoble',
            ],
            [
                'titre'       => 'Formation Analyse de Logs & SIEM',
                'description' => 'Déploiement d\'un SIEM open source, corrélation d\'alertes et réponse aux incidents.',
                'dateDebut'   => new \DateTimeImmutable('+15 days'),
                'capaciteMax' => 20,
                'isPublished' => true,
                'lieu'        => 'Salle SOC — CESI, Rouen',
            ],
            [
                'titre'       => 'Formation OSINT Avancé',
                'description' => 'Maltego, Shodan, Recon-ng et techniques avancées de collecte d\'informations ouvertes.',
                'dateDebut'   => new \DateTimeImmutable('+19 days'),
                'capaciteMax' => 18,
                'isPublished' => true,
                'lieu'        => 'Salle OSINT — Campus Cyber, Paris',
            ],
            [
                'titre'       => 'Formation Développement Sécurisé PHP/Symfony',
                'description' => 'Bonnes pratiques de code sécurisé : validation, CSRF, injection et gestion des secrets.',
                'dateDebut'   => new \DateTimeImmutable('+23 days'),
                'capaciteMax' => 22,
                'isPublished' => true,
                'lieu'        => 'Salle Web — AFPA Numérique, Strasbourg',
            ],
            [
                'titre'       => 'Formation Hacking Éthique — Niveau 2',
                'description' => 'Approfondissement post-exploitation, pivoting réseau et techniques d\'évasion AV.',
                'dateDebut'   => new \DateTimeImmutable('+29 days'),
                'capaciteMax' => 16,
                'isPublished' => true,
                'lieu'        => 'Lab Offensif — Offensive Security Center, Paris',
            ],
            [
                'titre'       => 'Formation Réponse à Incident',
                'description' => 'Procédures DFIR, triage, containment et communication de crise cyber.',
                'dateDebut'   => new \DateTimeImmutable('+37 days'),
                'capaciteMax' => 20,
                'isPublished' => false,
                'lieu'        => 'CERT Lab — Sophos, Marseille',
            ],
            [
                'titre'       => 'Formation Sécurité des Applications Mobiles',
                'description' => 'OWASP Mobile Top 10, tests sur Android et iOS, outils Frida et MobSF.',
                'dateDebut'   => new \DateTimeImmutable('+44 days'),
                'capaciteMax' => 20,
                'isPublished' => true,
                'lieu'        => 'Salle Mobile — Epitech Lyon',
            ],
            [
                'titre'       => 'Formation Firewall & Réseau Défensif',
                'description' => 'Configuration pfSense, règles iptables, VPN site-à-site et segmentation VLAN.',
                'dateDebut'   => new \DateTimeImmutable('+52 days'),
                'capaciteMax' => 24,
                'isPublished' => true,
                'lieu'        => 'Lab Réseau — Cisco Academy, Lille',
            ],
            [
                'titre'       => 'Formation Gouvernance & ISO 27001',
                'description' => 'Mise en place d\'un SMSI, analyse de risques et préparation à la certification ISO 27001.',
                'dateDebut'   => new \DateTimeImmutable('+60 days'),
                'capaciteMax' => 30,
                'isPublished' => false,
                'lieu'        => 'Centre Formation BSI, Paris',
            ],

            // ── ÉVÉNEMENTS SPÉCIAUX ──
            [
                'titre'       => 'Hackathon Cybersécurité 48h',
                'description' => 'Hackathon intensif en équipe sur des problématiques réelles de sécurité proposées par des sponsors.',
                'dateDebut'   => new \DateTimeImmutable('+8 days'),
                'capaciteMax' => 200,
                'isPublished' => true,
                'lieu'        => 'Station F, Paris',
            ],
            [
                'titre'       => 'Journée Portes Ouvertes CyberCampus',
                'description' => 'Découverte du Campus Cyber : démonstrations live, rencontres avec des professionnels et stands.',
                'dateDebut'   => new \DateTimeImmutable('+24 days'),
                'capaciteMax' => 500,
                'isPublished' => true,
                'lieu'        => 'Campus Cyber, La Défense',
            ],
            [
                'titre'       => 'Table Ronde — Femmes & Cybersécurité',
                'description' => 'Parcours de professionnelles du secteur, initiatives de diversité et opportunités de carrière.',
                'dateDebut'   => new \DateTimeImmutable('+27 days'),
                'capaciteMax' => 80,
                'isPublished' => true,
                'lieu'        => 'Maison des Associations, Bordeaux',
            ],
            [
                'titre'       => 'Meetup SecOps & DevSecOps',
                'description' => 'Échanges informels autour de l\'intégration de la sécurité dans les pipelines CI/CD.',
                'dateDebut'   => new \DateTimeImmutable('+32 days'),
                'capaciteMax' => 60,
                'isPublished' => true,
                'lieu'        => 'WeWork Nation, Paris',
            ],
            [
                'titre'       => 'Compétition Nationale CTF Étudiante',
                'description' => 'Compétition inter-écoles sur une plateforme dédiée avec classement en temps réel.',
                'dateDebut'   => new \DateTimeImmutable('+39 days'),
                'capaciteMax' => 300,
                'isPublished' => true,
                'lieu'        => 'CentraleSupélec, Gif-sur-Yvette',
            ],
            [
                'titre'       => 'Speed Networking Cybersécurité',
                'description' => 'Rencontres courtes et efficaces avec des recruteurs, experts et entrepreneurs du secteur.',
                'dateDebut'   => new \DateTimeImmutable('+46 days'),
                'capaciteMax' => 100,
                'isPublished' => true,
                'lieu'        => 'L\'Usine Digitale, Paris',
            ],
            [
                'titre'       => 'Cyber Escape Game — Hack the Room',
                'description' => 'Résoudre des défis de sécurité pour s\'échapper de la salle dans un format ludique et immersif.',
                'dateDebut'   => new \DateTimeImmutable('+49 days'),
                'capaciteMax' => 30,
                'isPublished' => true,
                'lieu'        => 'CyberRoom Escape, Lyon',
            ],
            [
                'titre'       => 'Afterwork Cyber — Édition Spéciale',
                'description' => 'Soirée networking décontractée pour la communauté cyber : talks courts, démonstrations et échanges.',
                'dateDebut'   => new \DateTimeImmutable('+56 days'),
                'capaciteMax' => 120,
                'isPublished' => true,
                'lieu'        => 'Le Cargo, Marseille',
            ],
            [
                'titre'       => 'Séminaire Cyber Défense Nationale',
                'description' => 'Intervention d\'experts ANSSI, DGA et opérateurs d\'importance vitale sur la cyberdéfense française.',
                'dateDebut'   => new \DateTimeImmutable('+62 days'),
                'capaciteMax' => 150,
                'isPublished' => false,
                'lieu'        => 'Hôtel National des Invalides, Paris',
            ],
            [
                'titre'       => 'Certification Prep Day — CISSP',
                'description' => 'Journée intensive de révision pour la certification CISSP avec formateurs accrédités (ISC)².',
                'dateDebut'   => new \DateTimeImmutable('+67 days'),
                'capaciteMax' => 40,
                'isPublished' => true,
                'lieu'        => 'Centre Pearson Vue, Paris',
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
