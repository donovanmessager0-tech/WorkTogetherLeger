<?php

namespace App\Entity;

use App\Repository\UtilisateurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UtilisateurRepository::class)]
class Utilisateur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $identifiant = null;

    #[ORM\Column(length: 255)]
    private ?string $mdp = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    /**
     * @var Collection<int, Role>
     */
    #[ORM\OneToMany(targetEntity: Role::class, mappedBy: 'utilisateur')]
    private Collection $Role;

    public function __construct()
    {
        $this->Role = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdentifiant(): ?string
    {
        return $this->identifiant;
    }

    public function setIdentifiant(string $identifiant): static
    {
        $this->identifiant = $identifiant;

        return $this;
    }

    public function getMdp(): ?string
    {
        return $this->mdp;
    }

    public function setMdp(string $mdp): static
    {
        $this->mdp = $mdp;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return Collection<int, Role>
     */
    public function getRole(): Collection
    {
        return $this->Role;
    }

    public function addRole(Role $role): static
    {
        if (!$this->Role->contains($role)) {
            $this->Role->add($role);
            $role->setUtilisateur($this);
        }

        return $this;
    }

    public function removeRole(Role $role): static
    {
        if ($this->Role->removeElement($role)) {
            // set the owning side to null (unless already changed)
            if ($role->getUtilisateur() === $this) {
                $role->setUtilisateur(null);
            }
        }

        return $this;
    }
}
