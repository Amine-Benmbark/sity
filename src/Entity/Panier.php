<?php

namespace App\Entity;

use App\Repository\PanierRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PanierRepository::class)]
class Panier
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    // #[ORM\Column(type: 'integer')]
    // private $quantite = null;

    #[ORM\ManyToMany(targetEntity: Produit::class, mappedBy: 'panier')]
    private Collection $produits;

    #[ORM\OneToMany(mappedBy: 'panier', targetEntity: PanierProduit::class, cascade: ['persist','remove'])]
    private Collection $article;

    #[ORM\OneToOne(inversedBy: 'panier')]
    #[ORM\JoinColumn(name: 'user_id', referencedColumnName: 'id')]
    private ?User $User = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: false)]
    private \DateTimeInterface $createdAt;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: false)]
    private \DateTimeInterface $updatedAt ;

    public function __construct()
    {
        $this->produits = new ArrayCollection();
        $this->article = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    // public function getQuantite(): ?int
    // {
    //     return $this->quantite;
    // }

    // public function setQuantite(int $quantite): self
    // {
    //     $this->quantite = $quantite;

    //     return $this;
    // }

    /**
     * @return Collection<int, Produit>
     */
    public function getProduits(): Collection
    {
        return $this->produits;
    }

    public function addProduit(Produit $produit): self
    {
        if (!$this->produits->contains($produit)) {
            $this->produits->add($produit);
            $produit->addPanier($this);
        }

        return $this;
    }

    public function removeProduit(Produit $produit): self
    {
        if ($this->produits->removeElement($produit)) {
            $produit->removePanier($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, PanierProduit>
     */
    public function getArticle(): Collection
    {
        return $this->article;
    }

    public function addArticle(PanierProduit $article): self
    {
        if (!$this->article->contains($article)) {
            $this->article->add($article);
            $article->setPanier($this);
        }

        return $this;
    }

    public function removeArticle(PanierProduit $article): self
    {
        if ($this->article->removeElement($article)) {
            // set the owning side to null (unless already changed)
            if ($article->getPanier() === $this) {
                $article->setPanier(null);
            }
        }

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->User;
    }

    public function setUser(?User $User): self
    {
        $this->User = $User;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
