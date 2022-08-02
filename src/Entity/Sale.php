<?php

namespace App\Entity;

use App\Repository\SaleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SaleRepository::class)]
class Sale
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nombreTienda = null;

    #[ORM\OneToMany(mappedBy: 'tienda', targetEntity: Product::class)]
    private Collection $products;

    #[ORM\OneToMany(mappedBy: 'sale', targetEntity: Customer::class)]
    private Collection $customer;

    // #[ORM\OneToOne(mappedBy: 'idSale', cascade: ['persist', 'remove'])]
    // private ?Compra $idSale = null;

    // #[ORM\OneToMany(mappedBy: 'idCompra', targetEntity: Compra::class)]
    // private Collection $idCompra;

    public function __construct($nombreTienda=null)
    {
        $this->nombreTienda = $nombreTienda;
        $this->products = new ArrayCollection();
        $this->customer = new ArrayCollection();
        $this->idCompra = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombreTienda(): ?string
    {
        return $this->nombreTienda;
    }

    public function setNombreTienda(string $nombreTienda): self
    {
        $this->nombreTienda = $nombreTienda;

        return $this;
    }

    /**
     * @return Collection<int, Product>
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Product $product): self
    {
        if (!$this->products->contains($product)) {
            $this->products->add($product);
            $product->setTienda($this);
        }

        return $this;
    }

    public function removeProduct(Product $product): self
    {
        if ($this->products->removeElement($product)) {
            // set the owning side to null (unless already changed)
            if ($product->getTienda() === $this) {
                $product->setTienda(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Customer>
     */
    public function getCustomer(): Collection
    {
        return $this->customer;
    }

    public function addCustomer(Customer $customer): self
    {
        if (!$this->customer->contains($customer)) {
            $this->customer->add($customer);
            $customer->setSale($this);
        }

        return $this;
    }

    public function removeCustomer(Customer $customer): self
    {
        if ($this->customer->removeElement($customer)) {
            // set the owning side to null (unless already changed)
            if ($customer->getSale() === $this) {
                $customer->setSale(null);
            }
        }

        return $this;
    }

    public function getIdSale(): ?Compra
    {
        return $this->idSale;
    }

    public function setIdSale(?Compra $idSale): self
    {
        // unset the owning side of the relation if necessary
        if ($idSale === null && $this->idSale !== null) {
            $this->idSale->setIdSale(null);
        }

        // set the owning side of the relation if necessary
        if ($idSale !== null && $idSale->getIdSale() !== $this) {
            $idSale->setIdSale($this);
        }

        $this->idSale = $idSale;

        return $this;
    }

    /**
     * @return Collection<int, Compra>
     */
    public function getIdCompra(): Collection
    {
        return $this->idCompra;
    }

    public function addIdCompra(Compra $idCompra): self
    {
        if (!$this->idCompra->contains($idCompra)) {
            $this->idCompra->add($idCompra);
            $idCompra->setIdCompra($this);
        }

        return $this;
    }

    public function removeIdCompra(Compra $idCompra): self
    {
        if ($this->idCompra->removeElement($idCompra)) {
            // set the owning side to null (unless already changed)
            if ($idCompra->getIdCompra() === $this) {
                $idCompra->setIdCompra(null);
            }
        }

        return $this;
    }
}
