<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\TableRowDefinitionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TableRowDefinitionRepository::class)]
#[ApiResource]
class TableRowDefinition
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $rowId = null;

    #[ORM\Column(length: 10)]
    private ?string $type = null;

    #[ORM\Column]
    private ?int $groupId = null;

    #[ORM\Column(length: 255)]
    private ?string $groupTitle = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $layer = null;

    #[ORM\Column(length: 255)]
    private ?string $displayName = null;

    #[ORM\Column(length: 255)]
    private ?string $repository = null;

    #[ORM\Column]
    private ?int $repositoryIdNomen = null;

    #[ORM\Column(nullable: true)]
    private ?int $repositoryIdTaxo = null;

    #[ORM\ManyToOne(inversedBy: 'rowsDefinition')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Table $_table = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRowId(): ?int
    {
        return $this->rowId;
    }

    public function setRowId(int $rowId): self
    {
        $this->rowId = $rowId;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getGroupId(): ?int
    {
        return $this->groupId;
    }

    public function setGroupId(int $groupId): self
    {
        $this->groupId = $groupId;

        return $this;
    }

    public function getGroupTitle(): ?string
    {
        return $this->groupTitle;
    }

    public function setGroupTitle(string $groupTitle): self
    {
        $this->groupTitle = $groupTitle;

        return $this;
    }

    public function getLayer(): ?string
    {
        return $this->layer;
    }

    public function setLayer(?string $layer): self
    {
        $this->layer = $layer;

        return $this;
    }

    public function getDisplayName(): ?string
    {
        return $this->displayName;
    }

    public function setDisplayName(string $displayName): self
    {
        $this->displayName = $displayName;

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

    public function setRepositoryIdNomen(int $repositoryIdNomen): self
    {
        $this->repositoryIdNomen = $repositoryIdNomen;

        return $this;
    }

    public function getRepositoryIdTaxo(): ?int
    {
        return $this->repositoryIdTaxo;
    }

    public function setRepositoryIdTaxo(?int $repositoryIdTaxo): self
    {
        $this->repositoryIdTaxo = $repositoryIdTaxo;

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
