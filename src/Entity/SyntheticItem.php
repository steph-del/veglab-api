<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\SyntheticItemRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SyntheticItemRepository::class)]
#[ApiResource]
class SyntheticItem
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'items')]
    #[ORM\JoinColumn(nullable: false)]
    private ?SyntheticColumn $syntheticColumn = null;

    #[ORM\Column(length: 255)]
    private ?string $layer = null;

    #[ORM\Column(length: 255)]
    private ?string $repository = null;

    #[ORM\Column(nullable: true)]
    private ?int $repositoryIdNomen = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $repositoryIdTaxo = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $displayName = null;

    #[ORM\Column]
    private ?int $occurrenceCount = null;

    #[ORM\Column]
    private ?bool $isOccurrenceCountEstimated = null;

    #[ORM\Column]
    private ?float $frequency = null;

    #[ORM\Column(length: 10, nullable: true)]
    private ?string $coef = null;

    #[ORM\Column(length: 10, nullable: true)]
    private ?string $minCoef = null;

    #[ORM\Column(length: 10, nullable: true)]
    private ?string $maxCoef = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getLayer(): ?string
    {
        return $this->layer;
    }

    public function setLayer(string $layer): self
    {
        $this->layer = $layer;

        return $this;
    }

    public function getRepository(): ?string
    {
        return $this->repository;
    }

    public function setRepository(string $repository): self
    {
        $this->repository = $repository;

        return $this;
    }

    public function getRepositoryIdNomen(): ?int
    {
        return $this->repositoryIdNomen;
    }

    public function setRepositoryIdNomen(?int $repositoryIdNomen): self
    {
        $this->repositoryIdNomen = $repositoryIdNomen;

        return $this;
    }

    public function getRepositoryIdTaxo(): ?string
    {
        return $this->repositoryIdTaxo;
    }

    public function setRepositoryIdTaxo(?string $repositoryIdTaxo): self
    {
        $this->repositoryIdTaxo = $repositoryIdTaxo;

        return $this;
    }

    public function getDisplayName(): ?string
    {
        return $this->displayName;
    }

    public function setDisplayName(?string $displayName): self
    {
        $this->displayName = $displayName;

        return $this;
    }

    public function getOccurrenceCount(): ?int
    {
        return $this->occurrenceCount;
    }

    public function setOccurrenceCount(int $occurrenceCount): self
    {
        $this->occurrenceCount = $occurrenceCount;

        return $this;
    }

    public function isIsOccurrenceCountEstimated(): ?bool
    {
        return $this->isOccurrenceCountEstimated;
    }

    public function setIsOccurrenceCountEstimated(bool $isOccurrenceCountEstimated): self
    {
        $this->isOccurrenceCountEstimated = $isOccurrenceCountEstimated;

        return $this;
    }

    public function getFrequency(): ?float
    {
        return $this->frequency;
    }

    public function setFrequency(float $frequency): self
    {
        $this->frequency = $frequency;

        return $this;
    }

    public function getCoef(): ?string
    {
        return $this->coef;
    }

    public function setCoef(?string $coef): self
    {
        $this->coef = $coef;

        return $this;
    }

    public function getMinCoef(): ?string
    {
        return $this->minCoef;
    }

    public function setMinCoef(?string $minCoef): self
    {
        $this->minCoef = $minCoef;

        return $this;
    }

    public function getMaxCoef(): ?string
    {
        return $this->maxCoef;
    }

    public function setMaxCoef(?string $maxCoef): self
    {
        $this->maxCoef = $maxCoef;

        return $this;
    }
}
