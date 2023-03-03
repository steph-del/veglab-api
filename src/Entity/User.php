<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Doctrine\UuidType;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[ApiResource]
class User implements UserInterface
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME)]
    private string $id;

    private string $ssoId;

    private array $roles;

    #[ORM\OneToMany(mappedBy: '_user', targetEntity: OccurrenceValidation::class)]
    private Collection $validation;

    #[ORM\OneToMany(mappedBy: 'userValidation', targetEntity: OccurrenceValidation::class)]
    private Collection $userValidation;

    #[ORM\OneToMany(mappedBy: '_user', targetEntity: Sye::class)]
    private Collection $sye;

    #[ORM\OneToMany(mappedBy: '_user', targetEntity: SyntheticColumn::class)]
    private Collection $syntheticColumn;

    #[ORM\OneToMany(mappedBy: '_user', targetEntity: Table::class)]
    private Collection $tables;

    #[ORM\OneToMany(mappedBy: '_user', targetEntity: Occurrence::class)]
    private Collection $occurrences;

    /**
     * @param string $id
     */
    public function __construct(string $id)
    {
        $this->id = $id;
        $this->validation = new ArrayCollection();
        $this->userValidation = new ArrayCollection();
        $this->sye = new ArrayCollection();
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
     * @return string
     */
    public function getSSoId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     *
     * @return User
     */
    public function setId(string $id): User
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @param array $roles
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
    public function eraseCredentials()
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
     * @return Collection<int, OccurrenceValidation>
     */
    public function getValidation(): Collection
    {
        return $this->validation;
    }

    public function addValidation(OccurrenceValidation $validation): self
    {
        if (!$this->validation->contains($validation)) {
            $this->validation->add($validation);
            $validation->setUser($this);
        }

        return $this;
    }

    public function removeValidation(OccurrenceValidation $validation): self
    {
        if ($this->validation->removeElement($validation)) {
            // set the owning side to null (unless already changed)
            if ($validation->getUser() === $this) {
                $validation->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, OccurrenceValidation>
     */
    public function getUserValidation(): Collection
    {
        return $this->userValidation;
    }

    public function addUserValidation(OccurrenceValidation $userValidation): self
    {
        if (!$this->userValidation->contains($userValidation)) {
            $this->userValidation->add($userValidation);
            $userValidation->setUserValidation($this);
        }

        return $this;
    }

    public function removeUserValidation(OccurrenceValidation $userValidation): self
    {
        if ($this->userValidation->removeElement($userValidation)) {
            // set the owning side to null (unless already changed)
            if ($userValidation->getUserValidation() === $this) {
                $userValidation->setUserValidation(null);
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
            $sye->setUser($this);
        }

        return $this;
    }

    public function removeSye(Sye $sye): self
    {
        if ($this->sye->removeElement($sye)) {
            // set the owning side to null (unless already changed)
            if ($sye->getUser() === $this) {
                $sye->setUser(null);
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
            $syntheticColumn->setUser($this);
        }

        return $this;
    }

    public function removeSyntheticColumn(SyntheticColumn $syntheticColumn): self
    {
        if ($this->syntheticColumn->removeElement($syntheticColumn)) {
            // set the owning side to null (unless already changed)
            if ($syntheticColumn->getUser() === $this) {
                $syntheticColumn->setUser(null);
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
            $table->setUser($this);
        }

        return $this;
    }

    public function removeTable(Table $table): self
    {
        if ($this->tables->removeElement($table)) {
            // set the owning side to null (unless already changed)
            if ($table->getUser() === $this) {
                $table->setUser(null);
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
            $occurrence->setUser($this);
        }

        return $this;
    }

    public function removeOccurrence(Occurrence $occurrence): self
    {
        if ($this->occurrences->removeElement($occurrence)) {
            // set the owning side to null (unless already changed)
            if ($occurrence->getUser() === $this) {
                $occurrence->setUser(null);
            }
        }

        return $this;
    }

}
