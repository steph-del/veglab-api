<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\TableRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TableRepository::class)]
#[ORM\Table(name: '`table`')]
#[ApiResource]
class Table
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToMany(mappedBy: '_table', targetEntity: TableRowDefinition::class)]
    private Collection $rowsDefinition;

    #[ORM\ManyToOne(inversedBy: 'tables')]
    private ?BiblioPhyto $vlBiblioSource = null;

    #[ORM\OneToMany(mappedBy: '_table', targetEntity: OccurrenceValidation::class)]
    private Collection $validations;

    #[ORM\OneToOne(mappedBy: '_table', cascade: ['persist', 'remove'])]
    private ?PdfFile $pdf = null;

    #[ORM\OneToMany(mappedBy: '_table', targetEntity: Sye::class)]
    private Collection $sye;

    #[ORM\OneToOne(mappedBy: '_table', cascade: ['persist', 'remove'])]
    private ?SyntheticColumn $syntheticColumn = null;

    #[ORM\ManyToOne(inversedBy: 'tables')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['table::read', 'table::create'])]
    private ?User $owner = null;

    #[ORM\Column]
    private ?bool $isDiagnosis = null;

    #[ORM\Column(length: 255)]
    private ?string $createdBy = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\Column(nullable: true)]
    private ?int $updatedBy = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $updatedAt = null;

    #[ORM\Column(length: 1024, nullable: true)]
    private ?string $syeOrder = null;

    #[ORM\Column(length: 100)]
    private ?string $title = null;

    #[ORM\Column(length: 300, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $vlWorkspace = null;

    public function __construct()
    {
        $this->rowsDefinition = new ArrayCollection();
        $this->validations = new ArrayCollection();
        $this->sye = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, TableRowDefinition>
     */
    public function getRowsDefinition(): Collection
    {
        return $this->rowsDefinition;
    }

    public function addRowsDefinition(TableRowDefinition $rowsDefinition): self
    {
        if (!$this->rowsDefinition->contains($rowsDefinition)) {
            $this->rowsDefinition->add($rowsDefinition);
            $rowsDefinition->setTable($this);
        }

        return $this;
    }

    public function removeRowsDefinition(TableRowDefinition $rowsDefinition): self
    {
        if ($this->rowsDefinition->removeElement($rowsDefinition)) {
            // set the owning side to null (unless already changed)
            if ($rowsDefinition->getTable() === $this) {
                $rowsDefinition->setTable(null);
            }
        }

        return $this;
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
            $validation->setTable($this);
        }

        return $this;
    }

    public function removeValidation(OccurrenceValidation $validation): self
    {
        if ($this->validations->removeElement($validation)) {
            // set the owning side to null (unless already changed)
            if ($validation->getTable() === $this) {
                $validation->setTable(null);
            }
        }

        return $this;
    }

    public function getPdf(): ?PdfFile
    {
        return $this->pdf;
    }

    public function setPdf(?PdfFile $pdf): self
    {
        // unset the owning side of the relation if necessary
        if ($pdf === null && $this->pdf !== null) {
            $this->pdf->setTable(null);
        }

        // set the owning side of the relation if necessary
        if ($pdf !== null && $pdf->getTable() !== $this) {
            $pdf->setTable($this);
        }

        $this->pdf = $pdf;

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
            $sye->setTable($this);
        }

        return $this;
    }

    public function removeSye(Sye $sye): self
    {
        if ($this->sye->removeElement($sye)) {
            // set the owning side to null (unless already changed)
            if ($sye->getTable() === $this) {
                $sye->setTable(null);
            }
        }

        return $this;
    }

    public function getSyntheticColumn(): ?SyntheticColumn
    {
        return $this->syntheticColumn;
    }

    public function setSyntheticColumn(SyntheticColumn $syntheticColumn): self
    {
        // set the owning side of the relation if necessary
        if ($syntheticColumn->getTable() !== $this) {
            $syntheticColumn->setTable($this);
        }

        $this->syntheticColumn = $syntheticColumn;

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

    public function isIsDiagnosis(): ?bool
    {
        return $this->isDiagnosis;
    }

    public function setIsDiagnosis(bool $isDiagnosis): self
    {
        $this->isDiagnosis = $isDiagnosis;

        return $this;
    }

    public function getCreatedBy(): ?string
    {
        return $this->createdBy;
    }

    public function setCreatedBy(string $createdBy): self
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedBy(): ?int
    {
        return $this->updatedBy;
    }

    public function setUpdatedBy(?int $updatedBy): self
    {
        $this->updatedBy = $updatedBy;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getSyeOrder(): ?string
    {
        return $this->syeOrder;
    }

    public function setSyeOrder(?string $syeOrder): self
    {
        $this->syeOrder = $syeOrder;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

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
