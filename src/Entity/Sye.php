<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use App\Repository\SyeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: SyeRepository::class)]
#[ApiResource]
#[Get(normalizationContext: ['groups' => 'sye::read'])]
class Sye
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['sye::read', 'table::read', 'table::create', 'table::update'])]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'syes')]
    #[Groups(['sye::read', 'table::read', 'table::create', 'table::update'])]
    private ?BiblioPhyto $vlBiblioSource = null;

    #[ORM\OneToMany(mappedBy: 'sye', targetEntity: ExtendedFieldOccurrence::class)]
    #[Groups(['sye::read', 'table::read', 'table::create', 'table::update'])]
    private Collection $extendedFieldOccurrences;

    #[ORM\ManyToMany(targetEntity: Occurrence::class, mappedBy: 'syes')]
    #[Groups(['sye::read', 'table::read', 'table::create', 'table::update'])]
    private Collection $occurrences;

    #[ORM\OneToMany(mappedBy: 'sye', targetEntity: Identification::class)]
    #[Groups(['sye::read', 'table::read', 'table::create', 'table::update'])]
    private Collection $identifications;

    #[ORM\Column]
    #[Groups(['sye::read', 'table::read', 'table::create', 'table::update'])]
    private ?int $syePosition = null;

    #[ORM\ManyToOne(inversedBy: 'sye')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['sye::read', 'table::read', 'table::create', 'table::update'])]
    private ?User $owner = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['sye::read', 'table::read', 'table::create', 'table::update'])]
    private ?int $occurrenceCount = null;

    #[ORM\Column(length: 1024, nullable: true)]
    #[Groups(['sye::read', 'table::read', 'table::create', 'table::update'])]
    private ?string $occurrencesOrder = null;

    #[ORM\OneToOne(inversedBy: 'sye', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(name: 'sye_synth_col', referencedColumnName: 'id', nullable: false)]
    #[Groups(['sye::read', 'table::read', 'table::create', 'table::update'])]
    private ?SyntheticColumn $syntheticColumn = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['sye::read', 'table::read', 'table::create', 'table::update'])]
    private ?bool $syntheticSye = null;

    #[ORM\Column]
    #[Groups(['sye::read', 'table::read', 'table::create', 'table::update'])]
    private ?bool $onlyShowSyntheticColumn = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['sye::read', 'table::read', 'table::create', 'table::update'])]
    private ?string $vlWorkspace = null;

    #[ORM\ManyToOne(inversedBy: 'sye')]
    #[ORM\JoinColumn(name: 'table_id', referencedColumnName: 'id')]
    private ?Table $_table = null;

    public function __construct()
    {
        $this->extendedFieldOccurrences = new ArrayCollection();
        $this->occurrences = new ArrayCollection();
        $this->identifications = new ArrayCollection();
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
            $extendedFieldOccurrence->setSye($this);
        }

        return $this;
    }

    public function removeExtendedFieldOccurrence(ExtendedFieldOccurrence $extendedFieldOccurrence): self
    {
        if ($this->extendedFieldOccurrences->removeElement($extendedFieldOccurrence)) {
            // set the owning side to null (unless already changed)
            if ($extendedFieldOccurrence->getSye() === $this) {
                $extendedFieldOccurrence->setSye(null);
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
            $occurrence->addSye($this);
        }

        return $this;
    }

    public function removeOccurrence(Occurrence $occurrence): self
    {
        if ($this->occurrences->removeElement($occurrence)) {
            $occurrence->removeSye($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Identification>
     */
    public function getIdentifications(): Collection
    {
        return $this->identifications;
    }

    public function addIdentification(Identification $identification): self
    {
        if (!$this->identifications->contains($identification)) {
            $this->identifications->add($identification);
            $identification->setSye($this);
        }

        return $this;
    }

    public function removeIdentification(Identification $identification): self
    {
        if ($this->identifications->removeElement($identification)) {
            // set the owning side to null (unless already changed)
            if ($identification->getSye() === $this) {
                $identification->setSye(null);
            }
        }

        return $this;
    }

    public function getSyePosition(): ?int
    {
        return $this->syePosition;
    }

    public function setSyePosition(int $syePosition): self
    {
        $this->syePosition = $syePosition;

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

    public function getOccurrenceCount(): ?int
    {
        return $this->occurrenceCount;
    }

    public function setOccurrenceCount(?int $occurrenceCount): self
    {
        $this->occurrenceCount = $occurrenceCount;

        return $this;
    }

    public function getOccurrencesOrder(): ?string
    {
        return $this->occurrencesOrder;
    }

    public function setOccurrencesOrder(?string $occurrencesOrder): self
    {
        $this->occurrencesOrder = $occurrencesOrder;

        return $this;
    }

    public function getSyntheticColumn(): ?SyntheticColumn
    {
        return $this->syntheticColumn;
    }

    public function setSyntheticColumn(?SyntheticColumn $syntheticColumn): self
    {
        $this->syntheticColumn = $syntheticColumn;

        return $this;
    }

    public function isSyntheticSye(): ?bool
    {
        return $this->syntheticSye;
    }

    public function setSyntheticSye(?bool $syntheticSye): self
    {
        $this->syntheticSye = $syntheticSye;

        return $this;
    }

    public function isOnlyShowSyntheticColumn(): ?bool
    {
        return $this->onlyShowSyntheticColumn;
    }

    public function setOnlyShowSyntheticColumn(bool $onlyShowSyntheticColumn): self
    {
        $this->onlyShowSyntheticColumn = $onlyShowSyntheticColumn;

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

    public function getTable(): ?Table
    {
        return $this->_table;
    }

    public function setTable(?Table $_table): self
    {
        $this->_table = $_table;

        return $this;
    }
}
