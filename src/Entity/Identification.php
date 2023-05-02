<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\IdentificationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;

#[ORM\Entity(repositoryClass: IdentificationRepository::class)]
#[ApiResource]
class Identification
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['table::read', 'table::create', 'occurrence::create'])]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'identifications')]
    #[Groups(['occurrence::create'])]
    private ?Occurrence $occurrence = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Groups(['table::read', 'table::create', 'occurrence::create'])]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['table::read', 'table::create', 'occurrence::create'])]
    private ?string $updatedBy = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Groups(['table::read', 'table::create', 'occurrence::create'])]
    private ?\DateTimeInterface $updatedAt = null;

    #[ORM\ManyToOne(inversedBy: 'identification')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['table::read', 'table::create', 'occurrence::create'])]
    private ?User $owner = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['table::read', 'table::create', 'occurrence::create'])]
    private ?string $repository = null;

    #[ORM\Column]
    #[Groups(['table::read', 'table::create', 'occurrence::create'])]
    private ?int $repositoryIdNomen = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['table::read', 'table::create', 'occurrence::create'])]
    private ?string $repositoryIdTaxo = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['table::read', 'table::create', 'occurrence::create'])]
    private ?string $citationName = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['table::read', 'table::create', 'occurrence::create'])]
    private ?string $nomenclaturalName = null;

    #[ORM\Column(length: 255)]
    #[Groups(['table::read', 'table::create', 'occurrence::create'])]
    private ?string $taxonomicalName = null;

    #[ORM\ManyToOne(inversedBy: 'identifications')]
    private ?SyntheticColumn $syntheticColumn = null;

    #[ORM\ManyToOne(inversedBy: 'identifications')]
    private ?Table $_table = null;

    #[ORM\ManyToOne(inversedBy: 'identifications')]
    private ?Sye $sye = null;

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

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedBy(): ?string
    {
        return $this->updatedBy;
    }

    public function setUpdatedBy(?string $updatedBy): self
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

    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function setOwner(?User $owner): self
    {
        $this->owner = $owner;

        return $this;
    }

    public function getRepository(): ?string
    {
        return $this->repository;
    }

    public function setRepository(?string $repository): self
    {
        $this->repository = $repository;

        return $this;
    }

    public function getRepositoryIdNomen(): ?int
    {
        return $this->repositoryIdNomen;
    }

    public function setRepositoryIdNomen(int $repositoryIdNomen): self
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

    public function getCitationName(): ?string
    {
        return $this->citationName;
    }

    public function setCitationName(?string $citationName): self
    {
        $this->citationName = $citationName;

        return $this;
    }

    public function getTaxonomicalName(): ?string
    {
        return $this->taxonomicalName;
    }

    public function setTaxonomicalName(string $taxonomicalName): self
    {
        $this->taxonomicalName = $taxonomicalName;

        return $this;
    }

    public function getNomenclaturalName(): ?string
    {
        return $this->nomenclaturalName;
    }

    public function setNomenclaturalName(?string $nomenclaturalName): self
    {
        $this->nomenclaturalName = $nomenclaturalName;

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

    public function getTable(): ?Table
    {
        return $this->_table;
    }

    public function setTable(?Table $_table): self
    {
        $this->_table = $_table;

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
}
