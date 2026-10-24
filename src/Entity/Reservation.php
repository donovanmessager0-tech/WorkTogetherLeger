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
    private ?Utilisateur $client = null;

    #[ORM\ManyToOne(inversedBy: 'reservations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Offre $offre = null;

    /**
     * @var Collection<int, Unite>
     */
    #[ORM\OneToMany(targetEntity: Unite::class, mappedBy: 'reservation')]
    private Collection $unites;

    public function __construct()
    {
        $this->baie = new ArrayCollection();
        $this->unites = new ArrayCollection();
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

    public function getClient(): ?Utilisateur
    {
        return $this->client;
    }

    public function setClient(?Utilisateur $client): static
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

    /**
     * @return Collection<int, Unite>
     */
    public function getUnites(): Collection
    {
        return $this->unites;
    }

    public function addUnite(Unite $unite): static
    {
        if (!$this->unites->contains($unite)) {
            $this->unites->add($unite);
            $unite->setReservation($this);
        }

        return $this;
    }

    public function removeUnite(Unite $unite): static
    {
        if ($this->unites->removeElement($unite)) {
            // set the owning side to null (unless already changed)
            if ($unite->getReservation() === $this) {
                $unite->setReservation(null);
            }
        }

        return $this;
    }
}
