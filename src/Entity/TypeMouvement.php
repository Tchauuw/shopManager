<?php

namespace App\Entity;

use App\Repository\TypeMouvementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TypeMouvementRepository::class)]
class TypeMouvement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    /**
     * @var Collection<int, StockMouvement>
     */
    #[ORM\OneToMany(targetEntity: StockMouvement::class, mappedBy: 'typeMouvement')]
    private Collection $stockMouvements;

    public function __construct()
    {
        $this->stockMouvements = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * @return Collection<int, StockMouvement>
     */
    public function getStockMouvements(): Collection
    {
        return $this->stockMouvements;
    }

    public function addStockMouvement(StockMouvement $stockMouvement): static
    {
        if (!$this->stockMouvements->contains($stockMouvement)) {
            $this->stockMouvements->add($stockMouvement);
            $stockMouvement->setTypeMouvement($this);
        }

        return $this;
    }

    public function removeStockMouvement(StockMouvement $stockMouvement): static
    {
        if ($this->stockMouvements->removeElement($stockMouvement)) {
            // set the owning side to null (unless already changed)
            if ($stockMouvement->getTypeMouvement() === $this) {
                $stockMouvement->setTypeMouvement(null);
            }
        }

        return $this;
    }
}
