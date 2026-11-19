<?php

namespace App\Entity;

use App\Repository\TypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TypeRepository::class)]
class Type
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Name = null;

    #[ORM\Column(length: 255)]
    private ?string $Color = null;

    /**
     * @var Collection<int, Unite>
     */
    #[ORM\OneToMany(targetEntity: Unite::class, mappedBy: 'type')]
    private Collection $Unite;

    public function __construct()
    {
        $this->Unite = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->Name;
    }

    public function setName(string $Name): static
    {
        $this->Name = $Name;

        return $this;
    }

    public function getColor(): ?string
    {
        return $this->Color;
    }

    public function setColor(string $Color): static
    {
        $this->Color = $Color;

        return $this;
    }

    /**
     * @return Collection<int, Unite>
     */
    public function getUnite(): Collection
    {
        return $this->Unite;
    }

    public function addUnite(Unite $unite): static
    {
        if (!$this->Unite->contains($unite)) {
            $this->Unite->add($unite);
            $unite->setType($this);
        }

        return $this;
    }

    public function removeUnite(Unite $unite): static
    {
        if ($this->Unite->removeElement($unite)) {
            // set the owning side to null (unless already changed)
            if ($unite->getType() === $this) {
                $unite->setType(null);
            }
        }

        return $this;
    }
}
