<?php

namespace App\Entity;

use App\Repository\EventRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: EventRepository::class)]
class Event
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    #[Groups(['api_event_read'])]
    #[ORM\Column(length: 255)]
    private ?string $titre = null;

    #[Groups(['api_event_read'])]
    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[Groups(['api_event_read'])]
    #[ORM\Column]
    private ?\DateTimeImmutable $dateDebut = null;

    
    #[ORM\Column]
    private ?int $capaciteMax = null;

    #[ORM\Column]
    private ?bool $isPublished = null;

    
    #[ORM\Column(length: 255)]
    private ?string $lieu = null;

    /**
     * @var Collection<int, User>
     */
    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'reservation')]
    private Collection $reservation;

    public function __construct()
    {
        $this->reservation = new ArrayCollection();
    }

    /**
     * Retourne le statut dynamique de l'événement selon l'heure actuelle.
     * - "à venir"   : avant la date de début
     * - "en cours"  : entre dateDebut et dateDebut + 2h30
     * - "terminé"   : après dateDebut + 2h30
     */
    public function getStatut(): string
    {
        if ($this->dateDebut === null) {
            return 'inconnu';
        }

        $now = new \DateTimeImmutable('now', new \DateTimeZone('UTC'));
        $debut = $this->dateDebut->setTimezone(new \DateTimeZone('UTC'));
        $fin = $debut->modify('+2 hours 30 minutes');

        if ($now < $debut) {
            return 'à venir';
        }

        if ($now >= $debut && $now <= $fin) {
            return 'en cours';
        }

        return 'terminé';
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): static
    {
        $this->titre = $titre;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getDateDebut(): ?\DateTimeImmutable
    {
        return $this->dateDebut;
    }

    public function setDateDebut(\DateTimeImmutable $dateDebut): static
    {
        $this->dateDebut = $dateDebut->setTimezone(new \DateTimeZone('Europe/Paris'));
        return $this;
    }

    public function getCapaciteMax(): ?int
    {
        return $this->capaciteMax;
    }

    public function setCapaciteMax(int $capaciteMax): static
    {
        $this->capaciteMax = $capaciteMax;

        return $this;
    }

    public function isPublished(): ?bool
    {
        return $this->isPublished;
    }

    public function setIsPublished(bool $isPublished): static
    {
        $this->isPublished = $isPublished;

        return $this;
    }

    public function getLieu(): ?string
    {
        return $this->lieu;
    }

    public function setLieu(string $lieu): static
    {
        $this->lieu = $lieu;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getReservation(): Collection
    {
        return $this->reservation;
    }

    public function addReservation(User $reservation): static
    {
        if (!$this->reservation->contains($reservation)) {
            $this->reservation->add($reservation);
        }

        return $this;
    }

    public function removeReservation(User $reservation): static
    {
        $this->reservation->removeElement($reservation);

        return $this;
    }
}
