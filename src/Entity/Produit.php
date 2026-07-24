<?php

namespace App\Entity;

use App\Repository\ProduitRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProduitRepository::class)]
class Produit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    private ?string $reference = null;

    #[ORM\Column]
    private ?bool $actif = null;

    #[ORM\Column]
    private ?float $prixHT = null;

    #[ORM\Column(length: 255)]
    private ?string $illustration = null;

    /**
     * @var Collection<int, Categorie>
     */
    #[ORM\ManyToMany(targetEntity: Categorie::class, inversedBy: 'produits')]
    private Collection $categorie;

    #[ORM\ManyToOne(inversedBy: 'produits')]
    private ?Marque $marque = null;

    /**
     * @var Collection<int, ProduitsAssocies>
     */
    #[ORM\ManyToMany(targetEntity: ProduitsAssocies::class, mappedBy: 'produit')]
    private Collection $produitsAssocies;

    public function __construct()
    {
        $this->categorie = new ArrayCollection();
        $this->produitsAssocies = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(string $reference): static
    {
        $this->reference = $reference;

        return $this;
    }

    public function isActif(): ?bool
    {
        return $this->actif;
    }

    public function setActif(bool $actif): static
    {
        $this->actif = $actif;

        return $this;
    }

    public function getPrixHT(): ?float
    {
        return $this->prixHT;
    }

    public function setPrixHT(float $prixHT): static
    {
        $this->prixHT = $prixHT;

        return $this;
    }

    public function getIllustration(): ?string
    {
        return $this->illustration;
    }

    public function setIllustration(string $illustration): static
    {
        $this->illustration = $illustration;

        return $this;
    }

    /**
     * @return Collection<int, Categorie>
     */
    public function getCategorie(): Collection
    {
        return $this->categorie;
    }

    public function addCategorie(Categorie $categorie): static
    {
        if (!$this->categorie->contains($categorie)) {
            $this->categorie->add($categorie);
        }

        return $this;
    }

    public function removeCategorie(Categorie $categorie): static
    {
        $this->categorie->removeElement($categorie);

        return $this;
    }

    public function getMarque(): ?Marque
    {
        return $this->marque;
    }

    public function setMarque(?Marque $marque): static
    {
        $this->marque = $marque;

        return $this;
    }

    /**
     * @return Collection<int, ProduitsAssocies>
     */
    public function getProduitsAssocies(): Collection
    {
        return $this->produitsAssocies;
    }

    public function addProduitsAssocy(ProduitsAssocies $produitsAssocy): static
    {
        if (!$this->produitsAssocies->contains($produitsAssocy)) {
            $this->produitsAssocies->add($produitsAssocy);
            $produitsAssocy->addProduit($this);
        }

        return $this;
    }

    public function removeProduitsAssocy(ProduitsAssocies $produitsAssocy): static
    {
        if ($this->produitsAssocies->removeElement($produitsAssocy)) {
            $produitsAssocy->removeProduit($this);
        }

        return $this;
    }
}
