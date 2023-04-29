<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\ObserverRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ObserverRepository::class)]
#[ApiResource]
class Observer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['table::create'])]
    private ?int $id = null;

    // @TODO check cascade props
    #[ORM\ManyToMany(targetEntity: Occurrence::class, inversedBy: 'vlObservers', cascade: ['persist', 'remove'])]
    private Collection $occurrences;

    #[ORM\Column(length: 255)]
    #[Groups(['table::create'])]
    private ?string $name = null;

    public function __construct()
    {
        $this->occurrences = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

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
        }

        return $this;
    }

    public function removeOccurrence(Occurrence $occurrence): self
    {
        $this->occurrences->removeElement($occurrence);

        return $this;
    }
}
