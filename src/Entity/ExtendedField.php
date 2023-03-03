<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\ExtendedFieldRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ExtendedFieldRepository::class)]
#[ApiResource]
class ExtendedField
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $fieldId = null;

    #[ORM\Column(length: 50)]
    private ?string $projectName = null;

    #[ORM\Column(length: 255)]
    private ?string $dataType = null;

    #[ORM\Column]
    private ?bool $isVisible = null;

    #[ORM\Column(nullable: true)]
    private ?bool $isEditable = null;

    #[ORM\Column(nullable: true)]
    private ?bool $isMandatory = null;

    #[ORM\Column(nullable: true)]
    private ?float $minValue = null;

    #[ORM\Column(nullable: true)]
    private ?float $maxValue = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $defaultValue = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $regexp = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $unit = null;

    #[ORM\Column(nullable: true)]
    private ?float $filterStep = null;

    #[ORM\Column(nullable: true)]
    private ?bool $filterLogarithmic = null;

    #[ORM\OneToMany(mappedBy: 'extendedField', targetEntity: ExtendedFieldOccurrence::class)]
    private Collection $extendedFieldOccurrences;

    #[ORM\OneToMany(mappedBy: 'extendedField', targetEntity: ExtendedFieldTranslation::class)]
    private Collection $extendedFieldTranslations;

    public function __construct()
    {
        $this->extendedFieldOccurrences = new ArrayCollection();
        $this->extendedFieldTranslations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFieldId(): ?string
    {
        return $this->fieldId;
    }

    public function setFieldId(string $fieldId): self
    {
        $this->fieldId = $fieldId;

        return $this;
    }

    public function getProjectName(): ?string
    {
        return $this->projectName;
    }

    public function setProjectName(string $projectName): self
    {
        $this->projectName = $projectName;

        return $this;
    }

    public function getDataType(): ?string
    {
        return $this->dataType;
    }

    public function setDataType(string $dataType): self
    {
        $this->dataType = $dataType;

        return $this;
    }

    public function isIsVisible(): ?bool
    {
        return $this->isVisible;
    }

    public function setIsVisible(bool $isVisible): self
    {
        $this->isVisible = $isVisible;

        return $this;
    }

    public function isIsEditable(): ?bool
    {
        return $this->isEditable;
    }

    public function setIsEditable(?bool $isEditable): self
    {
        $this->isEditable = $isEditable;

        return $this;
    }

    public function isIsMandatory(): ?bool
    {
        return $this->isMandatory;
    }

    public function setIsMandatory(?bool $isMandatory): self
    {
        $this->isMandatory = $isMandatory;

        return $this;
    }

    public function getMinValue(): ?float
    {
        return $this->minValue;
    }

    public function setMinValue(?float $minValue): self
    {
        $this->minValue = $minValue;

        return $this;
    }

    public function getMaxValue(): ?float
    {
        return $this->maxValue;
    }

    public function setMaxValue(?float $maxValue): self
    {
        $this->maxValue = $maxValue;

        return $this;
    }

    public function getDefaultValue(): ?string
    {
        return $this->defaultValue;
    }

    public function setDefaultValue(?string $defaultValue): self
    {
        $this->defaultValue = $defaultValue;

        return $this;
    }

    public function getRegexp(): ?string
    {
        return $this->regexp;
    }

    public function setRegexp(?string $regexp): self
    {
        $this->regexp = $regexp;

        return $this;
    }

    public function getUnit(): ?string
    {
        return $this->unit;
    }

    public function setUnit(?string $unit): self
    {
        $this->unit = $unit;

        return $this;
    }

    public function getFilterStep(): ?float
    {
        return $this->filterStep;
    }

    public function setFilterStep(?float $filterStep): self
    {
        $this->filterStep = $filterStep;

        return $this;
    }

    public function isFilterLogarithmic(): ?bool
    {
        return $this->filterLogarithmic;
    }

    public function setFilterLogarithmic(?bool $filterLogarithmic): self
    {
        $this->filterLogarithmic = $filterLogarithmic;

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
            $extendedFieldOccurrence->setExtendedField($this);
        }

        return $this;
    }

    public function removeExtendedFieldOccurrence(ExtendedFieldOccurrence $extendedFieldOccurrence): self
    {
        if ($this->extendedFieldOccurrences->removeElement($extendedFieldOccurrence)) {
            // set the owning side to null (unless already changed)
            if ($extendedFieldOccurrence->getExtendedField() === $this) {
                $extendedFieldOccurrence->setExtendedField(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ExtendedFieldTranslation>
     */
    public function getExtendedFieldTranslations(): Collection
    {
        return $this->extendedFieldTranslations;
    }

    public function addExtendedFieldTranslation(ExtendedFieldTranslation $extendedFieldTranslation): self
    {
        if (!$this->extendedFieldTranslations->contains($extendedFieldTranslation)) {
            $this->extendedFieldTranslations->add($extendedFieldTranslation);
            $extendedFieldTranslation->setExtendedField($this);
        }

        return $this;
    }

    public function removeExtendedFieldTranslation(ExtendedFieldTranslation $extendedFieldTranslation): self
    {
        if ($this->extendedFieldTranslations->removeElement($extendedFieldTranslation)) {
            // set the owning side to null (unless already changed)
            if ($extendedFieldTranslation->getExtendedField() === $this) {
                $extendedFieldTranslation->setExtendedField(null);
            }
        }

        return $this;
    }
}
