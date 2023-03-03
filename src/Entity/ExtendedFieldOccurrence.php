<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\ExtendedFieldOccurrenceRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ExtendedFieldOccurrenceRepository::class)]
#[ApiResource]
class ExtendedFieldOccurrence
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'extendedFieldOccurrences')]
    private ?Occurrence $occurrence = null;

    #[ORM\ManyToOne(inversedBy: 'extendedFieldOccurrences')]
    private ?Sye $sye = null;

    #[ORM\ManyToOne(inversedBy: 'extendedFieldOccurrences')]
    private ?SyntheticColumn $syntheticColumn = null;

    #[ORM\ManyToOne(inversedBy: 'extendedFieldOccurrences')]
    #[ORM\JoinColumn(nullable: false)]
    private ?ExtendedField $extendedField = null;

    #[ORM\Column(length: 255)]
    private ?string $value = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOccurrence(): ?Occurrence
    {
        return $this->occurrence;
    }

    public function setOccurrence(?Occurrence $occurrence): self
    {
        $this->occurrence = $occurrence;

        return $this;
    }

    public function getSye(): ?Sye
    {
        return $this->sye;
    }

    public function setSye(?Sye $sye): self
    {
        $this->sye = $sye;

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

    public function getExtendedField(): ?ExtendedField
    {
        return $this->extendedField;
    }

    public function setExtendedField(?ExtendedField $extendedField): self
    {
        $this->extendedField = $extendedField;

        return $this;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(string $value): self
    {
        $this->value = $value;

        return $this;
    }
}
