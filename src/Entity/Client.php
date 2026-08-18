<?php

namespace App\Entity;

use App\Repository\ClientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\DBAL\Types\Types;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClientRepository::class)]
class Client
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $prenom = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTime $dateNaissance = null;

    #[ORM\Column(length: 255)]
    private ?string $adresse = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $complementAdresse = null;

    #[ORM\Column(length: 255)]
    private ?string $codePostal = null;

    #[ORM\Column(length: 255)]
    private ?string $ville = null;

    #[ORM\Column(length: 255)]
    private ?string $pays = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $telephone = null;

    #[ORM\Column]
    private ?bool $newsletter = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $dateCreation = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?CarteFidelite $carteFidelite = null;

    #[ORM\OneToMany(mappedBy: 'client', targetEntity: Vente::class)]
    private Collection $ventes;

    /**
     * @return Collection<int, Vente>
     */
    public function getVentes(): Collection
    {
        return $this->ventes;
    }

    public function __construct()
    {
        $this->ventes = new ArrayCollection();
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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getDateNaissance(): ?\DateTime
    {
        return $this->dateNaissance;
    }

    public function setDateNaissance(?\DateTime $dateNaissance): static
    {
        $this->dateNaissance = $dateNaissance;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): static
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getComplementAdresse(): ?string
    {
        return $this->complementAdresse;
    }

    public function setComplementAdresse(?string $complementAdresse): static
    {
        $this->complementAdresse = $complementAdresse;

        return $this;
    }

    public function getCodePostal(): ?string
    {
        return $this->codePostal;
    }

    public function setCodePostal(string $codePostal): static
    {
        $this->codePostal = $codePostal;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): static
    {
        $this->ville = $ville;

        return $this;
    }

    public function getPays(): ?string
    {
        return $this->pays;
    }

    public function setPays(string $pays): static
    {
        $this->pays = $pays;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): static
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function isNewsletter(): ?bool
    {
        return $this->newsletter;
    }

    public function setNewsletter(bool $newsletter): static
    {
        $this->newsletter = $newsletter;

        return $this;
    }

    public function getDateCreation(): ?\DateTime
    {
        return $this->dateCreation;
    }

    public function setDateCreation(?\DateTime $dateCreation): static
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    public function getCarteFidelite(): ?CarteFidelite
    {
        return $this->carteFidelite;
    }

    public function setCarteFidelite(?CarteFidelite $carteFidelite): static
    {
        $this->carteFidelite = $carteFidelite;

        return $this;
    }

    public function nouveauOuNon(): int 
    {
        if(!$this->dateCreation) {
            return 0;
        }

        return $this->dateCreation->diff(new \DateTimeImmutable())->days;
    }

    public function getNombreVentes(): int
    {
        return $this->ventes->count();
    }

    public function getStatut(): string
    {
    $nombreVentes = $this->getNombreVentes();

    if ($nombreVentes > 3) {
        return 'fidele';
    }

    if ($nombreVentes > 2) {
        return 'regulier';
    }

    if ($this->NouveauOuNon() < 31) {
        return 'nouveau';
    }

    return 'a_developper';
}
}
