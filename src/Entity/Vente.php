<?php

namespace App\Entity;

use App\Repository\VenteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VenteRepository::class)]
class Vente
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $reference = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $date = null;

    #[ORM\Column]
    private ?float $montantTotal = null;

    #[ORM\Column]
    private ?float $montantTVA = null;

    #[ORM\ManyToOne(inversedBy: 'ventes')]
    private ?StatutPaiement $statutPaiement = null;

    /**
     * @var Collection<int, ModePaiement>
     */
    #[ORM\ManyToMany(targetEntity: ModePaiement::class, mappedBy: 'vente')]
    private Collection $modePaiements;

    #[ORM\ManyToOne(cascade: ['persist', 'remove'])]
    private ?Client $client = null;

    public function __construct()
    {
        $this->modePaiements = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDate(): ?\DateTime
    {
        return $this->date;
    }

    public function setDate(\DateTime $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getMontantTotal(): ?float
    {
        return $this->montantTotal;
    }

    public function setMontantTotal(float $montantTotal): static
    {
        $this->montantTotal = $montantTotal;

        return $this;
    }

    public function getMontantTVA(): ?float
    {
        return $this->montantTVA;
    }

    public function setMontantTVA(float $montantTVA): static
    {
        $this->montantTVA = $montantTVA;

        return $this;
    }

    public function getStatutPaiement(): ?StatutPaiement
    {
        return $this->statutPaiement;
    }

    public function setStatutPaiement(?StatutPaiement $statutPaiement): static
    {
        $this->statutPaiement = $statutPaiement;

        return $this;
    }

    /**
     * @return Collection<int, ModePaiement>
     */
    public function getModePaiements(): Collection
    {
        return $this->modePaiements;
    }

    public function addModePaiement(ModePaiement $modePaiement): static
    {
        if (!$this->modePaiements->contains($modePaiement)) {
            $this->modePaiements->add($modePaiement);
            $modePaiement->addVente($this);
        }

        return $this;
    }

    public function removeModePaiement(ModePaiement $modePaiement): static
    {
        if ($this->modePaiements->removeElement($modePaiement)) {
            $modePaiement->removeVente($this);
        }

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): static
    {
        $this->client = $client;

        return $this;
    }
}
