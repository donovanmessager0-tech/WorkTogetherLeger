<?php

namespace App\Entity;

use App\Repository\ReservationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReservationRepository::class)]
class Reservation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var Collection<int, Baie>
     */
    #[ORM\OneToMany(targetEntity: Baie::class, mappedBy: 'reservation')]
    private Collection $baie;

    #[ORM\ManyToOne(inversedBy: 'reservations')]
    private ?Client $client = null;

    #[ORM\ManyToOne(inversedBy: 'reservations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Offre $offre = null;

    public function __construct()
    {
        $this->baie = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Baie>
     */
    public function getBaie(): Collection
    {
        return $this->baie;
    }

    public function addBaie(Baie $baie): static
    {
        if (!$this->baie->contains($baie)) {
            $this->baie->add($baie);
            $baie->setReservation($this);
        }

        return $this;
    }

    public function removeBaie(Baie $baie): static
    {
        if ($this->baie->removeElement($baie)) {
            // set the owning side to null (unless already changed)
            if ($baie->getReservation() === $this) {
                $baie->setReservation(null);
            }
        }

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): static
    {
        $this->client = $client;

        return $this;
    }

    public function getOffre(): ?Offre
    {
        return $this->offre;
    }

    public function setOffre(?Offre $offre): static
    {
        $this->offre = $offre;

        return $this;
    }
}
