<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\PdfFileRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Annotation\Groups;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
#[ORM\Entity(repositoryClass: PdfFileRepository::class)]
#[ApiResource]
#[Vich\Uploadable]
class PdfFile
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['table::read', 'table::create'])]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'pdfFiles')]
    private ?BiblioPhyto $vlBiblioSource = null;

    #[ORM\Column(length: 190)]
    #[Groups(['table::read', 'table::create'])]
    private ?string $originalName = null;

    #[Vich\UploadableField(mapping: "media_object", fileNameProperty: "contentUrl", mimeType: "mimeType", originalName: "originalName")]
    private ?string $file = null;

    #[ORM\Column(length: 255)]
    #[Groups(['table::read', 'table::create'])]
    private ?string $contentUrl = null;

    #[ORM\Column(length: 255)]
    #[Groups(['table::read', 'table::create'])]
    private ?string $mimeType = null;

    #[ORM\Column(length: 255)]
    #[Groups(['table::read', 'table::create'])]
    private ?string $url = null;

    #[ORM\OneToOne(inversedBy: 'pdf', cascade: ['persist', 'remove'])]
    private ?Table $_table = null;

    #[ORM\Column(type: 'datetime')]
    #[Groups(['table::read', 'table::create'])]
    private ?\DateTimeInterface $updatedAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setFile(?File $file = null): void {
        $this->file = $file;

        // It is required that at least one field changes if you are using doctrine
        // otherwise the event listeners won't be called and the file is lost
        $this->updatedAt = new \DateTimeImmutable();
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

    public function getOriginalName(): ?string
    {
        return $this->originalName;
    }

    public function setOriginalName(string $originalName): self
    {
        $this->originalName = $originalName;

        return $this;
    }

    public function getContentUrl(): ?string
    {
        return $this->contentUrl;
    }

    public function setContentUrl(string $contentUrl): self
    {
        $this->contentUrl = $contentUrl;

        return $this;
    }

    public function getMimeType(): ?string
    {
        return $this->mimeType;
    }

    public function setMimeType(string $mimeType): self
    {
        $this->mimeType = $mimeType;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

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

    /**
     * @return \DateTimeInterface|null
     */
    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTimeInterface|null $updatedAt
     */
    public function setUpdatedAt(?\DateTimeInterface $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }
}
