<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\BiblioPhytoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: BiblioPhytoRepository::class)]
#[ApiResource]
class BiblioPhyto
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['table::read', 'table::create'])]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(['table::read', 'table::create'])]
    private ?string $title = null;

    #[ORM\OneToMany(mappedBy: 'vlBiblioSource', targetEntity: Occurrence::class)]
    private Collection $occurrences;

    #[ORM\OneToMany(mappedBy: 'vlBiblioSource', targetEntity: Table::class)]
    private Collection $tables;

    #[ORM\OneToMany(mappedBy: 'vlBiblioSource', targetEntity: Sye::class)]
    private Collection $syes;

    #[ORM\OneToMany(mappedBy: 'vlBiblioSource', targetEntity: SyntheticColumn::class)]
    private Collection $syntheticColumns;

    #[ORM\OneToMany(mappedBy: 'vlBiblioSource', targetEntity: PdfFile::class)]
    private Collection $pdfFiles;

    public function __construct()
    {
        $this->occurrences = new ArrayCollection();
        $this->tables = new ArrayCollection();
        $this->syes = new ArrayCollection();
        $this->syntheticColumns = new ArrayCollection();
        $this->pdfFiles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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
            $occurrence->setVlBiblioSource($this);
        }

        return $this;
    }

    public function removeOccurrence(Occurrence $occurrence): self
    {
        if ($this->occurrences->removeElement($occurrence)) {
            // set the owning side to null (unless already changed)
            if ($occurrence->getVlBiblioSource() === $this) {
                $occurrence->setVlBiblioSource(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Table>
     */
    public function getTables(): Collection
    {
        return $this->tables;
    }

    public function addTable(Table $table): self
    {
        if (!$this->tables->contains($table)) {
            $this->tables->add($table);
            $table->setVlBiblioSource($this);
        }

        return $this;
    }

    public function removeTable(Table $table): self
    {
        if ($this->tables->removeElement($table)) {
            // set the owning side to null (unless already changed)
            if ($table->getVlBiblioSource() === $this) {
                $table->setVlBiblioSource(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Sye>
     */
    public function getSyes(): Collection
    {
        return $this->syes;
    }

    public function addSye(Sye $sye): self
    {
        if (!$this->syes->contains($sye)) {
            $this->syes->add($sye);
            $sye->setVlBiblioSource($this);
        }

        return $this;
    }

    public function removeSye(Sye $sye): self
    {
        if ($this->syes->removeElement($sye)) {
            // set the owning side to null (unless already changed)
            if ($sye->getVlBiblioSource() === $this) {
                $sye->setVlBiblioSource(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, SyntheticColumn>
     */
    public function getSyntheticColumns(): Collection
    {
        return $this->syntheticColumns;
    }

    public function addSyntheticColumn(SyntheticColumn $syntheticColumn): self
    {
        if (!$this->syntheticColumns->contains($syntheticColumn)) {
            $this->syntheticColumns->add($syntheticColumn);
            $syntheticColumn->setVlBiblioSource($this);
        }

        return $this;
    }

    public function removeSyntheticColumn(SyntheticColumn $syntheticColumn): self
    {
        if ($this->syntheticColumns->removeElement($syntheticColumn)) {
            // set the owning side to null (unless already changed)
            if ($syntheticColumn->getVlBiblioSource() === $this) {
                $syntheticColumn->setVlBiblioSource(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, PdfFile>
     */
    public function getPdfFiles(): Collection
    {
        return $this->pdfFiles;
    }

    public function addPdfFile(PdfFile $pdfFile): self
    {
        if (!$this->pdfFiles->contains($pdfFile)) {
            $this->pdfFiles->add($pdfFile);
            $pdfFile->setVlBiblioSource($this);
        }

        return $this;
    }

    public function removePdfFile(PdfFile $pdfFile): self
    {
        if ($this->pdfFiles->removeElement($pdfFile)) {
            // set the owning side to null (unless already changed)
            if ($pdfFile->getVlBiblioSource() === $this) {
                $pdfFile->setVlBiblioSource(null);
            }
        }

        return $this;
    }
}
