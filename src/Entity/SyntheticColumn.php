<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\SyntheticColumnRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;

#[ORM\Entity(repositoryClass: SyntheticColumnRepository::class)]
#[ApiResource]
class SyntheticColumn
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['table::read', 'table::create'])]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'syntheticColumns')]
    #[Groups(['table::read', 'table::create'])]
    private ?BiblioPhyto $vlBiblioSource = null;

    #[ORM\OneToMany(mappedBy: 'syntheticColumn', targetEntity: ExtendedFieldOccurrence::class)]
    #[Groups(['table::read', 'table::create'])]
    private Collection $extendedFieldOccurrences;

    #[ORM\OneToMany(mappedBy: 'syntheticColumn', targetEntity: OccurrenceValidation::class)]
    #[Groups(['table::read', 'table::create'])]
    private Collection $validations;

    #[ORM\OneToOne(mappedBy: 'syntheticColumn', cascade: ['persist', 'remove'])]
    private ?Sye $sye = null;

    #[ORM\ManyToOne(inversedBy: 'syntheticColumn')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['table::read', 'table::create'])]
    private ?User $owner = null;

    #[ORM\OneToOne(mappedBy: 'syntheticColumn')]
    private ?Table $table = null;

    #[ORM\OneToMany(mappedBy: 'syntheticColumn', targetEntity: SyntheticItem::class, cascade: ['persist', 'remove'])]
    #[Groups(['table::read', 'table::create'])]
    private Collection $items;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['table::read', 'table::create'])]
    private ?string $vlWorkspace = null;

    public function __construct()
    {
        $this->extendedFieldOccurrences = new ArrayCollection();
        $this->validations = new ArrayCollection();
        $this->items = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVlBiblioSource(): ?BiblioPhyto
    {
        return $this->vlBiblioSource;
    }

    public function setVlBiblioSource(?BiblioPhyto $vlBiblioSource): self
    {
        $this->vlBiblioSource = $vlBiblioSource;

        return $this;
    }

    /**
     * @return Collection<int, ExtendedFieldOccurrence>
     */
    public function getExtendedFieldOccurrences(): Collection
    {
        return $this->extendedFieldOccurrences;
    }

    public function addExtendedFieldOccurrence(ExtendedFieldOccurrence $extendedFieldOccurrence): self
    {
        if (!$this->extendedFieldOccurrences->contains($extendedFieldOccurrence)) {
            $this->extendedFieldOccurrences->add($extendedFieldOccurrence);
            $extendedFieldOccurrence->setSyntheticColumn($this);
        }

        return $this;
    }

    public function removeExtendedFieldOccurrence(ExtendedFieldOccurrence $extendedFieldOccurrence): self
    {
        if ($this->extendedFieldOccurrences->removeElement($extendedFieldOccurrence)) {
            // set the owning side to null (unless already changed)
            if ($extendedFieldOccurrence->getSyntheticColumn() === $this) {
                $extendedFieldOccurrence->setSyntheticColumn(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, OccurrenceValidation>
     */
    public function getValidations(): Collection
    {
        return $this->validations;
    }

    public function addValidation(OccurrenceValidation $validation): self
    {
        if (!$this->validations->contains($validation)) {
            $this->validations->add($validation);
            $validation->setSyntheticColumn($this);
        }

        return $this;
    }

    public function removeValidation(OccurrenceValidation $validation): self
    {
        if ($this->validations->removeElement($validation)) {
            // set the owning side to null (unless already changed)
            if ($validation->getSyntheticColumn() === $this) {
                $validation->setSyntheticColumn(null);
            }
        }

        return $this;
    }

    public function getSye(): ?Sye
    {
        return $this->sye;
    }

    public function setSye(?Sye $sye): self
    {
        // unset the owning side of the relation if necessary
        if ($sye === null && $this->sye !== null) {
            $this->sye->setSyntheticColumn(null);
        }

        // set the owning side of the relation if necessary
        if ($sye !== null && $sye->getSyntheticColumn() !== $this) {
            $sye->setSyntheticColumn($this);
        }

        $this->sye = $sye;

        return $this;
    }

    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function setOwner(?User $owner): self
    {
        $this->owner = $owner;

        return $this;
    }

    public function getTable(): ?Table
    {
        return $this->table;
    }

    public function setTable(Table $table): self
    {
        $this->table = $table;

        return $this;
    }

    /**
     * @return Collection<int, SyntheticItem>
     */
    public function getItems(): Collection
    {
        return $this->items;
    }

    public function addItem(SyntheticItem $item): self
    {
        if (!$this->items->contains($item)) {
            $this->items->add($item);
            $item->setSyntheticColumn($this);
        }

        return $this;
    }

    public function removeItem(SyntheticItem $item): self
    {
        if ($this->items->removeElement($item)) {
            // set the owning side to null (unless already changed)
            if ($item->getSyntheticColumn() === $this) {
                $item->setSyntheticColumn(null);
            }
        }

        return $this;
    }

    public function getVlWorkspace(): ?string
    {
        return $this->vlWorkspace;
    }

    public function setVlWorkspace(?string $vlWorkspace): self
    {
        $this->vlWorkspace = $vlWorkspace;

        return $this;
    }
}
