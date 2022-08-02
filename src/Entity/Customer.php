<?php

namespace App\Entity;

use App\Repository\CustomerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CustomerRepository::class)]
class Customer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $documento = null;

    #[ORM\Column(length: 255)]
    private ?string $nombres = null;

    #[ORM\ManyToOne(inversedBy: 'customer')]
    private ?Sale $sale = null;

    #[ORM\OneToMany(mappedBy: 'customer', targetEntity: Product::class)]
    private Collection $productos;


    public function __construct($documento=null,$nombres=null)
    {
        $this->documento = $documento;
        $this->nombres = $nombres;
        $this->productos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDocumento(): ?string
    {
        return $this->documento;
    }

    public function setDocumento(string $documento): self
    {
        $this->documento = $documento;

        return $this;
    }

    public function getNombres(): ?string
    {
        return $this->nombres;
    }

    public function setNombres(string $nombres): self
    {
        $this->nombres = $nombres;

        return $this;
    }

    public function getSale(): ?Sale
    {
        return $this->sale;
    }

    public function setSale(?Sale $sale): self
    {
        $this->sale = $sale;

        return $this;
    }

    /**
     * @return Collection<int, Product>
     */
    public function getProductos(): Collection
    {
        return $this->productos;
    }

    public function addProducto(Product $producto): self
    {
        if (!$this->productos->contains($producto)) {
            $this->productos->add($producto);
            $producto->setCustomer($this);
        }

        return $this;
    }

    public function removeProducto(Product $producto): self
    {
        if ($this->productos->removeElement($producto)) {
            // set the owning side to null (unless already changed)
            if ($producto->getCustomer() === $this) {
                $producto->setCustomer(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Compras>
     */
    public function getIdCompra(): Collection
    {
        return $this->idCompra;
    }

    // public function addIdCompra(Compras $idCompra): self
    // {
    //     if (!$this->idCompra->contains($idCompra)) {
    //         $this->idCompra->add($idCompra);
    //         $idCompra->addIdCliente($this);
    //     }

    //     return $this;
    // }

    // public function removeIdCompra(Compras $idCompra): self
    // {
    //     if ($this->idCompra->removeElement($idCompra)) {
    //         $idCompra->removeIdCliente($this);
    //     }

    //     return $this;
    // }
}
