<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use App\Repository\OccurrenceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;

#[ORM\Entity(repositoryClass: OccurrenceRepository::class)]
#[ApiResource]
#[Get]
#[Post(denormalizationContext: ['groups' => ['occurrence::create']])]
class Occurrence
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['table::read', 'table::create'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['table::read', 'table::create', 'occurrence::create'])]
    private ?string $level = null;

    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'children')]
    #[ORM\JoinColumn(nullable: true)]
    // https://api-platform.com/docs/core/serialization/#force-iri-with-relations-of-the-same-type-parentchilds-relations
    private ?self $parent = null;

    #[ORM\OneToMany(mappedBy: 'parent', targetEntity: self::class, cascade: ['persist', 'remove'])]
    #[Groups(['table::read', 'table::create', 'occurrence::create'])]
    private Collection $children;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['table::read', 'table::create'])]
    private ?string $parentLevel = null;

    #[ORM\Column(length: 255)]
    #[Groups(['table::read', 'table::create', 'occurrence::create'])]
    private ?string $layer = null;

    #[ORM\ManyToMany(targetEntity: Observer::class, mappedBy: 'occurrences', cascade: ["persist"])]
    #[ORM\JoinTable(name: "vl_occurrence__observer")]
    #[ORM\JoinColumn(name: "vl_observer_id", referencedColumnName: "id", nullable: true, onDelete: "SET NULL")]
    #[Groups(['table::read', 'table::create', 'occurrence::create'])]
    private Collection $vlObservers;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['table::read', 'table::create', 'occurrence::create'])]
    private ?string $vlWorkspace = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Groups(['table::read', 'table::create', 'occurrence::create'])]
    private ?\DateTimeInterface $dateObserved = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['table::read', 'table::create', 'occurrence::create'])]
    private ?string $dateObservedPrecision = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups(['table::read', 'table::create', 'occurrence::create'])]
    private ?\DateTimeInterface $dateCreated = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Groups(['table::read', 'table::create', 'occurrence::create'])]
    private ?\DateTimeInterface $dateUpdated = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Groups(['table::read', 'table::create', 'occurrence::create'])]
    private ?\DateTimeInterface $datePublished = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['table::read', 'table::create','occurrence::create'])]
    private ?string $certainty = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['table::read', 'table::create', 'occurrence::create'])]
    private ?string $annotation = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['table::read', 'table::create', 'occurrence::create'])]
    private ?string $occurrenceType = null;

    #[ORM\Column(length: 50, nullable: true)]
    #[Groups(['table::read', 'table::create', 'occurrence::create'])]
    private ?string $coef = null;

    #[ORM\ManyToOne(inversedBy: 'occurrences')]
    #[Groups(['table::read', 'table::create', 'occurrence::create'])]
    private ?BiblioPhyto $vlBiblioSource = null;

    #[ORM\Column]
    #[Groups(['table::read', 'table::create', 'occurrence::create'])]
    private ?bool $isPublic = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(['table::read', 'table::create', 'occurrence::create'])]
    private ?string $signature = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['table::read', 'table::create', 'occurrence::create'])]
    private ?string $geometry = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['table::read', 'table::create', 'occurrence::create'])]
    private ?string $centroid = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['table::read', 'table::create', 'occurrence::create'])]
    private ?int $elevation = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['table::read', 'table::create', 'occurrence::create'])]
    private ?bool $isElevationEstimated = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['table::read', 'table::create', 'occurrence::create'])]
    private ?string $geodatum = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['table::read', 'table::create', 'occurrence::create'])]
    private ?string $locality = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['table::read', 'table::create', 'occurrence::create'])]
    private ?string $localityInseeCode = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['table::read', 'table::create', 'occurrence::create'])]
    private ?string $publishedLocation = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['table::read', 'table::create', 'occurrence::create'])]
    private ?string $vlLocationAccuracy = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['table::read', 'table::create', 'occurrence::create'])]
    private ?string $osmCounty = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['table::read', 'table::create', 'occurrence::create'])]
    private ?string $osmState = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['table::read', 'table::create', 'occurrence::create'])]
    private ?string $osmPostCode = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['table::read', 'table::create', 'occurrence::create'])]
    private ?string $osmCountry = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['table::read', 'table::create', 'occurrence::create'])]
    private ?string $osmCountryCode = null;

    #[ORM\Column(type: Types::BIGINT, nullable: true)]
    #[Groups(['table::read', 'table::create', 'occurrence::create'])]
    private ?string $osmId = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['table::read', 'table::create', 'occurrence::create'])]
    private ?int $osmPlaceId = null;

    #[ORM\OneToMany(mappedBy: 'occurrence', targetEntity: OccurrenceValidation::class, cascade: ["persist"])]
    #[Groups(['table::read', 'table::create', 'occurrence::create'])]
    private Collection $validations;

    #[ORM\OneToMany(mappedBy: 'occurrence', targetEntity: ExtendedFieldOccurrence::class)]
    #[Groups(['table::read', 'table::create', 'occurrence::create'])]
    private Collection $extendedFieldOccurrences;

    #[ORM\ManyToMany(targetEntity: Sye::class, inversedBy: 'occurrences')]
    private Collection $syes;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['table::read', 'table::create', 'occurrence::create'])]
    #[SerializedName("userId")]
    private ?string $userId = null;

    #[ORM\ManyToOne(inversedBy: 'occurrences')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['table::read', 'table::create', 'occurrence::create'])]
    private ?User $owner = null;

    public function __construct()
    {
        $this->vlObservers = new ArrayCollection();
        $this->children = new ArrayCollection();
        $this->validations = new ArrayCollection();
        $this->extendedFieldOccurrences = new ArrayCollection();
        $this->syes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Observer>
     */
    public function getVlObservers(): Collection
    {
        return $this->vlObservers;
    }

    public function addVlObserver(Observer $vlObserver): self
    {
        if (!$this->vlObservers->contains($vlObserver)) {
            $this->vlObservers->add($vlObserver);
            $vlObserver->addOccurrence($this);
        }

        return $this;
    }

    public function removeVlObserver(Observer $vlObserver): self
    {
        if ($this->vlObservers->removeElement($vlObserver)) {
            $vlObserver->removeOccurrence($this);
        }

        return $this;
    }

    public function getUserId(): ?string
    {
        return $this->userId;
    }

    public function setUserId(?string $userId): self
    {
        $this->userId = $userId;

        return $this;
    }

    public function getLevel(): ?string
    {
        return $this->level;
    }

    public function setLevel(string $level): self
    {
        $this->level = $level;

        return $this;
    }

    public function getParent(): ?self
    {
        return $this->parent;
    }

    public function setParent(?self $parent): self
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getChildren(): Collection
    {
        return $this->children;
    }

    public function addChild(self $child): self
    {
        if (!$this->children->contains($child)) {
            $this->children->add($child);
            $child->setParent($this);
        }

        return $this;
    }

    public function removeChild(self $child): self
    {
        if ($this->children->removeElement($child)) {
            // set the owning side to null (unless already changed)
            if ($child->getParent() === $this) {
                $child->setParent(null);
            }
        }

        return $this;
    }

    public function getParentLevel(): ?string
    {
        return $this->parentLevel;
    }

    public function setParentLevel(?string $parentLevel): self
    {
        $this->parentLevel = $parentLevel;

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

    public function getVlWorkspace(): ?string
    {
        return $this->vlWorkspace;
    }

    public function setVlWorkspace(?string $vlWorkspace): self
    {
        $this->vlWorkspace = $vlWorkspace;

        return $this;
    }

    public function getDateObserved(): ?\DateTimeInterface
    {
        return $this->dateObserved;
    }

    public function setDateObserved(?\DateTimeInterface $dateObserved): self
    {
        $this->dateObserved = $dateObserved;

        return $this;
    }

    public function getDateObservedPrecision(): ?string
    {
        return $this->dateObservedPrecision;
    }

    public function setDateObservedPrecision(?string $dateObservedPrecision): self
    {
        $this->dateObservedPrecision = $dateObservedPrecision;

        return $this;
    }

    public function getDateCreated(): ?\DateTimeInterface
    {
        return $this->dateCreated;
    }

    public function setDateCreated(\DateTimeInterface $dateCreated): self
    {
        $this->dateCreated = $dateCreated;

        return $this;
    }

    public function getDateUpdated(): ?\DateTimeInterface
    {
        return $this->dateUpdated;
    }

    public function setDateUpdated(\DateTimeInterface $dateUpdated): self
    {
        $this->dateUpdated = $dateUpdated;

        return $this;
    }

    public function getDatePublished(): ?\DateTimeInterface
    {
        return $this->datePublished;
    }

    public function setDatePublished(?\DateTimeInterface $datePublished): self
    {
        $this->datePublished = $datePublished;

        return $this;
    }

    public function getCertainty(): ?string
    {
        return $this->certainty;
    }

    public function setCertainty(?string $certainty): self
    {
        $this->certainty = $certainty;

        return $this;
    }

    public function getAnnotation(): ?string
    {
        return $this->annotation;
    }

    public function setAnnotation(?string $annotation): self
    {
        $this->annotation = $annotation;

        return $this;
    }

    public function getOccurrenceType(): ?string
    {
        return $this->occurrenceType;
    }

    public function setOccurrenceType(?string $occurrenceType): self
    {
        $this->occurrenceType = $occurrenceType;

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

    public function getVlBiblioSource(): ?BiblioPhyto
    {
        return $this->vlBiblioSource;
    }

    public function setVlBiblioSource(?BiblioPhyto $vlBiblioSource): self
    {
        $this->vlBiblioSource = $vlBiblioSource;

        return $this;
    }

    public function getIsPublic(): ?bool
    {
        return $this->isPublic;
    }

    public function setIsPublic(bool $isPublic): self
    {
        $this->isPublic = $isPublic;

        return $this;
    }

    public function getSignature(): ?string
    {
        return $this->signature;
    }

    public function setSignature(string $signature): self
    {
        $this->signature = $signature;

        return $this;
    }

    public function getGeometry(): ?string
    {
        return $this->geometry;
    }

    public function setGeometry(?string $geometry): self
    {
        $this->geometry = $geometry;

        return $this;
    }

    public function getCentroid(): ?string
    {
        return $this->centroid;
    }

    public function setCentroid(?string $centroid): self
    {
        $this->centroid = $centroid;

        return $this;
    }

    public function getElevation(): ?int
    {
        return $this->elevation;
    }

    public function setElevation(?int $elevation): self
    {
        $this->elevation = $elevation;

        return $this;
    }

    public function getIsElevationEstimated(): ?bool
    {
        return $this->isElevationEstimated;
    }

    public function setIsElevationEstimated(?bool $isElevationEstimated): self
    {
        $this->isElevationEstimated = $isElevationEstimated;

        return $this;
    }

    public function getGeodatum(): ?string
    {
        return $this->geodatum;
    }

    public function setGeodatum(?string $geodatum): self
    {
        $this->geodatum = $geodatum;

        return $this;
    }

    public function getLocality(): ?string
    {
        return $this->locality;
    }

    public function setLocality(?string $locality): self
    {
        $this->locality = $locality;

        return $this;
    }

    public function getLocalityInseeCode(): ?string
    {
        return $this->localityInseeCode;
    }

    public function setLocalityInseeCode(?string $localityInseeCode): self
    {
        $this->localityInseeCode = $localityInseeCode;

        return $this;
    }

    public function getPublishedLocation(): ?string
    {
        return $this->publishedLocation;
    }

    public function setPublishedLocation(?string $publishedLocation): self
    {
        $this->publishedLocation = $publishedLocation;

        return $this;
    }

    public function getVlLocationAccuracy(): ?string
    {
        return $this->vlLocationAccuracy;
    }

    public function setVlLocationAccuracy(?string $vlLocationAccuracy): self
    {
        $this->vlLocationAccuracy = $vlLocationAccuracy;

        return $this;
    }

    public function getOsmCounty(): ?string
    {
        return $this->osmCounty;
    }

    public function setOsmCounty(?string $osmCounty): self
    {
        $this->osmCounty = $osmCounty;

        return $this;
    }

    public function getOsmState(): ?string
    {
        return $this->osmState;
    }

    public function setOsmState(?string $osmState): self
    {
        $this->osmState = $osmState;

        return $this;
    }

    public function getOsmPostCode(): ?string
    {
        return $this->osmPostCode;
    }

    public function setOsmPostCode(?string $osmPostCode): self
    {
        $this->osmPostCode = $osmPostCode;

        return $this;
    }

    public function getOsmCountry(): ?string
    {
        return $this->osmCountry;
    }

    public function setOsmCountry(?string $osmCountry): self
    {
        $this->osmCountry = $osmCountry;

        return $this;
    }

    public function getOsmCountryCode(): ?string
    {
        return $this->osmCountryCode;
    }

    public function setOsmCountryCode(?string $osmCountryCode): self
    {
        $this->osmCountryCode = $osmCountryCode;

        return $this;
    }

    public function getOsmId(): ?string
    {
        return $this->osmId;
    }

    public function setOsmId(?string $osmId): self
    {
        $this->osmId = $osmId;

        return $this;
    }

    public function getOsmPlaceId(): ?int
    {
        return $this->osmPlaceId;
    }

    public function setOsmPlaceId(?int $osmPlaceId): self
    {
        $this->osmPlaceId = $osmPlaceId;

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
            $validation->setOccurrence($this);
        }

        return $this;
    }

    public function removeValidation(OccurrenceValidation $validation): self
    {
        if ($this->validations->removeElement($validation)) {
            // set the owning side to null (unless already changed)
            if ($validation->getOccurrence() === $this) {
                $validation->setOccurrence(null);
            }
        }

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
            $extendedFieldOccurrence->setOccurrence($this);
        }

        return $this;
    }

    public function removeExtendedFieldOccurrence(ExtendedFieldOccurrence $extendedFieldOccurrence): self
    {
        if ($this->extendedFieldOccurrences->removeElement($extendedFieldOccurrence)) {
            // set the owning side to null (unless already changed)
            if ($extendedFieldOccurrence->getOccurrence() === $this) {
                $extendedFieldOccurrence->setOccurrence(null);
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
        }

        return $this;
    }

    public function removeSye(Sye $sye): self
    {
        $this->syes->removeElement($sye);

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

    /**
     * Some helpers
     */
    public function getFormattedDateObserved(): ?string {
        return (null !== $this->dateObserved) ? $this->dateObserved->format('Y-m-d H:i:s') : null;
    }


    public function getFormattedDateCreated(): ?string {
        return (null !== $this->dateCreated) ? $this->dateCreated->format('Y-m-d H:i:s') : null;
    }

    public function getFormattedDateUpdated(): ?string {
        return (null !== $this->dateUpdated) ? $this->dateUpdated->format('Y-m-d H:i:s') : null;
    }

    public function getFormattedDatePublished(): ?string {
        return (null !== $this->datePublished) ? $this->datePublished->format('Y-m-d H:i:s') : null;
    }

    public function getDateObservedMonth(): ?float {
        if ( null !== $this->dateObserved ) {
            return $this->dateObserved->format('m');
        }
        return null;
    }

    public function getDateObservedDay(): ?float {
        if ( null !== $this->dateObserved ) {
            return $this->dateObserved->format('d');
        }
        return null;
    }

    public function getDateObservedYear(): ?float {
        if ( null !== $this->dateObserved ) {
            return $this->dateObserved->format('Y');
        }

        return null;
    }
}
