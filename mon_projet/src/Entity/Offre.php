<?php

namespace App\Entity;

use App\Repository\OffreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OffreRepository::class)]
#[ORM\Table(name: 'offres')]
class Offre
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(type: Types::BIGINT)]
    private ?string $prix_mensuel = null;

    #[ORM\Column(type: Types::BIGINT)]
    private ?string $prix_annuel = null;

    #[ORM\Column]
    private ?int $nbunit = null;

    /**
     * @var Collection<int, Reservation>
     */
    #[ORM\OneToMany(targetEntity: Reservation::class, mappedBy: 'offre', orphanRemoval: true)]
    private Collection $reservations;

    public function __construct()
    {
        $this->reservations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrixMensuel(): ?string
    {
        return $this->prix_mensuel;
    }

    public function setPrixMensuel(string $prix_mensuel): static
    {
        $this->prix_mensuel = $prix_mensuel;

        return $this;
    }

    public function getPrixAnnuel(): ?string
    {
        return $this->prix_annuel;
    }

    public function setPrixAnnuel(string $prix_annuel): static
    {
        $this->prix_annuel = $prix_annuel;

        return $this;
    }

    public function getNbunit(): ?int
    {
        return $this->nbunit;
    }

    public function setNbunit(int $nbunit): static
    {
        $this->nbunit = $nbunit;

        return $this;
    }

    /**
     * @return Collection<int, Reservation>
     */
    public function getReservations(): Collection
    {
        return $this->reservations;
    }

    public function addReservation(Reservation $reservation): static
    {
        if (!$this->reservations->contains($reservation)) {
            $this->reservations->add($reservation);
            $reservation->setOffre($this);
        }

        return $this;
    }

    public function removeReservation(Reservation $reservation): static
    {
        if ($this->reservations->removeElement($reservation)) {
            // set the owning side to null (unless already changed)
            if ($reservation->getOffre() === $this) {
                $reservation->setOffre(null);
            }
        }

        return $this;
    }
}
