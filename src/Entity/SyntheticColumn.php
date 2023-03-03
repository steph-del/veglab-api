<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\SyntheticColumnRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SyntheticColumnRepository::class)]
#[ApiResource]
class SyntheticColumn
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'syntheticColumns')]
    private ?BiblioPhyto $vlBiblioSource = null;

    #[ORM\OneToMany(mappedBy: 'syntheticColumn', targetEntity: ExtendedFieldOccurrence::class)]
    private Collection $extendedFieldOccurrences;

    #[ORM\OneToMany(mappedBy: 'syntheticColumn', targetEntity: OccurrenceValidation::class)]
    private Collection $validations;

    #[ORM\OneToOne(mappedBy: 'syntheticColumn', cascade: ['persist', 'remove'])]
    private ?Sye $sye = null;

    #[ORM\ManyToOne(inversedBy: 'syntheticColumn')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $_user = null;

    #[ORM\OneToOne(inversedBy: 'syntheticColumn', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Table $_table = null;

    #[ORM\OneToMany(mappedBy: 'syntheticColumn', targetEntity: SyntheticItem::class)]
    private Collection $items;

    #[ORM\Column(length: 255, nullable: true)]
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

    public function getUser(): ?User
    {
        return $this->_user;
    }

    public function setUser(?User $_user): self
    {
        $this->_user = $_user;

        return $this;
    }

    public function getTable(): ?Table
    {
        return $this->_table;
    }

    public function setTable(Table $_table): self
    {
        $this->_table = $_table;

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
