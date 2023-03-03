<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\ExtendedFieldTranslationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ExtendedFieldTranslationRepository::class)]
#[ApiResource]
class ExtendedFieldTranslation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $label = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $defaultValue = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $errorMessage = null;

    #[ORM\Column(length: 3, nullable: true)]
    private ?string $languageIsoCode = null;

    #[ORM\Column(length: 15)]
    private ?string $help = null;

    #[ORM\ManyToOne(inversedBy: 'extendedFieldTranslations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?ExtendedField $extendedField = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): self
    {
        $this->label = $label;

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

    public function getDefaultValue(): ?string
    {
        return $this->defaultValue;
    }

    public function setDefaultValue(?string $defaultValue): self
    {
        $this->defaultValue = $defaultValue;

        return $this;
    }

    public function getErrorMessage(): ?string
    {
        return $this->errorMessage;
    }

    public function setErrorMessage(?string $errorMessage): self
    {
        $this->errorMessage = $errorMessage;

        return $this;
    }

    public function getLanguageIsoCode(): ?string
    {
        return $this->languageIsoCode;
    }

    public function setLanguageIsoCode(?string $languageIsoCode): self
    {
        $this->languageIsoCode = $languageIsoCode;

        return $this;
    }

    public function getHelp(): ?string
    {
        return $this->help;
    }

    public function setHelp(string $help): self
    {
        $this->help = $help;

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
}
