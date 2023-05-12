<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Doctrine\UuidType;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: 'vl_user')]
#[ApiResource]
#[Get(normalizationContext: ['groups' => ['user::read']])]
class User implements UserInterface
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME)]
    #[Groups(['user::read', 'occurrence::read', 'table::read', 'table::create', 'occurrence::create'])]
    private string $id;

    #[ORM\Column(length: 255)]
    #[Groups(['user::read'])]
    private ?string $firstname = null;

    #[ORM\Column(length: 255)]
    #[Groups(['user::read'])]
    private ?string $lastname = null;

    #[ORM\Column(length: 255)]
    #[Groups(['user::read'])]
    private ?string $email = null;

    #[Groups(['user::read'])]
    private array $roles;

    #[ORM\OneToMany(mappedBy: 'owner', targetEntity: Identification::class)]
    private Collection $identification;

    #[ORM\OneToMany(mappedBy: 'owner', targetEntity: Sye::class)]
    private Collection $sye;

    #[ORM\OneToMany(mappedBy: 'owner', targetEntity: SyntheticColumn::class)]
    private Collection $syntheticColumn;

    #[ORM\OneToMany(mappedBy: 'owner', targetEntity: Table::class)]
    private Collection $tables;

    #[ORM\OneToMany(mappedBy: 'owner', targetEntity: Occurrence::class)]
    private Collection $occurrences;

    /**
     * @param string $id
     */
    public function __construct(string $id)
    {
        $this->id             = $id;
        $this->identification = new ArrayCollection();
        $this->sye            = new ArrayCollection();
        $this->syntheticColumn = new ArrayCollection();
        $this->tables = new ArrayCollection();
        $this->occurrences = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     * @return User
     */
    public function setId(string $id): User
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @param array $roles
     * @return User
     */
    public function setRoles(array $roles): User
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @return array|string[]
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        $roles[] = 'ROLE_VEGLAB_USER';

        return array_unique($roles);
    }

    /**
     * @return void
     */
    public function eraseCredentials(): void
    {
        return;
    }

    /**
     * @return string
     */
    public function getUserIdentifier(): string
    {
        return $this->getId();
    }

    /**
     * @return Collection<int, Identification>
     */
    public function getIdentification(): Collection
    {
        return $this->identification;
    }

    public function addIdentification(Identification $identification): self
    {
        if (!$this->identification->contains($identification)) {
            $this->identification->add($identification);
            $identification->setOwner($this);
        }

        return $this;
    }

    public function removeIdentification(Identification $identification): self
    {
        if ($this->identification->removeElement($identification)) {
            // set the owning side to null (unless already changed)
            if ($identification->getOwner() === $this) {
                $identification->setOwner(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Sye>
     */
    public function getSye(): Collection
    {
        return $this->sye;
    }

    public function addSye(Sye $sye): self
    {
        if (!$this->sye->contains($sye)) {
            $this->sye->add($sye);
            $sye->setOwner($this);
        }

        return $this;
    }

    public function removeSye(Sye $sye): self
    {
        if ($this->sye->removeElement($sye)) {
            // set the owning side to null (unless already changed)
            if ($sye->getOwner() === $this) {
                $sye->setOwner(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, SyntheticColumn>
     */
    public function getSyntheticColumn(): Collection
    {
        return $this->syntheticColumn;
    }

    public function addSyntheticColumn(SyntheticColumn $syntheticColumn): self
    {
        if (!$this->syntheticColumn->contains($syntheticColumn)) {
            $this->syntheticColumn->add($syntheticColumn);
            $syntheticColumn->setOwner($this);
        }

        return $this;
    }

    public function removeSyntheticColumn(SyntheticColumn $syntheticColumn): self
    {
        if ($this->syntheticColumn->removeElement($syntheticColumn)) {
            // set the owning side to null (unless already changed)
            if ($syntheticColumn->getOwner() === $this) {
                $syntheticColumn->setOwner(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Table>
     */
    public function getTables(): Collection
    {
        return $this->tables;
    }

    public function addTable(Table $table): self
    {
        if (!$this->tables->contains($table)) {
            $this->tables->add($table);
            $table->setOwner($this);
        }

        return $this;
    }

    public function removeTable(Table $table): self
    {
        if ($this->tables->removeElement($table)) {
            // set the owning side to null (unless already changed)
            if ($table->getOwner() === $this) {
                $table->setOwner(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Occurrence>
     */
    public function getOccurrences(): Collection
    {
        return $this->occurrences;
    }

    public function addOccurrence(Occurrence $occurrence): self
    {
        if (!$this->occurrences->contains($occurrence)) {
            $this->occurrences->add($occurrence);
            $occurrence->setOwner($this);
        }

        return $this;
    }

    public function removeOccurrence(Occurrence $occurrence): self
    {
        if ($this->occurrences->removeElement($occurrence)) {
            // set the owning side to null (unless already changed)
            if ($occurrence->getOwner() === $this) {
                $occurrence->setOwner(null);
            }
        }

        return $this;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setFirstname(?string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getFirstName(): string
    {
        return $this->firstname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getLastName(): string
    {
        return $this->lastname;
    }

    public function getUsername(): string
    {
        return $this->getFirstName() . ' ' . $this->getLastName();
    }

    #[Groups(['user::read'])]
    public function getAcronym(): string
    {
        $words = preg_split("/\s+/", $this->getUsername());
        $acronym = '';
        foreach ($words as $word) {
            $acronym .= substr($word, 0, 1);
        }
        return $acronym;
    }

}
