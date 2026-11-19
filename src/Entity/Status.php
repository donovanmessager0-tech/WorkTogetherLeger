<?php

namespace App\Entity;

use App\Repository\StatusRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StatusRepository::class)]
class Status
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var Collection<int, Unite>
     */
    #[ORM\OneToMany(targetEntity: Unite::class, mappedBy: 'status')]
    private Collection $Name;

    public function __construct()
    {
        $this->Name = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Unite>
     */
    public function getName(): Collection
    {
        return $this->Name;
    }

    public function addName(Unite $name): static
    {
        if (!$this->Name->contains($name)) {
            $this->Name->add($name);
            $name->setStatus($this);
        }

        return $this;
    }

    public function removeName(Unite $name): static
    {
        if ($this->Name->removeElement($name)) {
            // set the owning side to null (unless already changed)
            if ($name->getStatus() === $this) {
                $name->setStatus(null);
            }
        }

        return $this;
    }
}
