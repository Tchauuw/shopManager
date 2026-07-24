<?php

namespace App\Entity;

use App\Repository\LigneVenteRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LigneVenteRepository::class)]
class LigneVente
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $quantite = null;

    #[ORM\Column]
    private ?float $prixUnitaireHT = null;

    #[ORM\Column]
    private ?float $prixUnitaireTTC = null;

    #[ORM\ManyToOne(inversedBy: 'ligneVentes')]
    private ?Taxe $taxe = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Produit $produit = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQuantite(int $quantite): static
    {
        $this->quantite = $quantite;

        return $this;
    }

    public function getPrixUnitaireHT(): ?float
    {
        return $this->prixUnitaireHT;
    }

    public function setPrixUnitaireHT(float $prixUnitaireHT): static
    {
        $this->prixUnitaireHT = $prixUnitaireHT;

        return $this;
    }

    public function getPrixUnitaireTTC(): ?float
    {
        return $this->prixUnitaireTTC;
    }

    public function setPrixUnitaireTTC(float $prixUnitaireTTC): static
    {
        $this->prixUnitaireTTC = $prixUnitaireTTC;

        return $this;
    }

    public function getTaxe(): ?Taxe
    {
        return $this->taxe;
    }

    public function setTaxe(?Taxe $taxe): static
    {
        $this->taxe = $taxe;

        return $this;
    }

    public function getProduit(): ?Produit
    {
        return $this->produit;
    }

    public function setProduit(?Produit $produit): static
    {
        $this->produit = $produit;

        return $this;
    }
}
