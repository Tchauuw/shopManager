<?php

namespace App\Entity;

use App\Repository\CarteFideliteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CarteFideliteRepository::class)]
class CarteFidelite
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $dateCreation = null;

    #[ORM\Column]
    private ?int $soldePoints = null;

    /**
     * @var Collection<int, MouvementFidelite>
     */
    #[ORM\OneToMany(targetEntity: MouvementFidelite::class, mappedBy: 'carteFidelite')]
    private Collection $mouvementFidelite;

    public function __construct()
    {
        $this->mouvementFidelite = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateCreation(): ?\DateTime
    {
        return $this->dateCreation;
    }

    public function setDateCreation(\DateTime $dateCreation): static
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    public function getSoldePoints(): ?int
    {
        return $this->soldePoints;
    }

    public function setSoldePoints(int $soldePoints): static
    {
        $this->soldePoints = $soldePoints;

        return $this;
    }

    /**
     * @return Collection<int, MouvementFidelite>
     */
    public function getMouvementFidelite(): Collection
    {
        return $this->mouvementFidelite;
    }

    public function addMouvementFidelite(MouvementFidelite $mouvementFidelite): static
    {
        if (!$this->mouvementFidelite->contains($mouvementFidelite)) {
            $this->mouvementFidelite->add($mouvementFidelite);
            $mouvementFidelite->setCarteFidelite($this);
        }

        return $this;
    }

    public function removeMouvementFidelite(MouvementFidelite $mouvementFidelite): static
    {
        if ($this->mouvementFidelite->removeElement($mouvementFidelite)) {
            // set the owning side to null (unless already changed)
            if ($mouvementFidelite->getCarteFidelite() === $this) {
                $mouvementFidelite->setCarteFidelite(null);
            }
        }

        return $this;
    }
}
