<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $codigo = null;

    #[ORM\Column(length: 255)]
    private ?string $nombre = null;

    #[ORM\Column]
    private ?int $stock = null;

    #[ORM\ManyToOne(inversedBy: 'products')]
    private ?Sale $tienda = null;

    #[ORM\ManyToOne(inversedBy: 'productos')]
    private ?Customer $customer = null;

    #[ORM\Column]
    private ?int $precio = null;

    #[ORM\Column]
    private ?int $cantidad = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $fechaCompra = null;

    // #[ORM\OneToOne(mappedBy: 'idProduct', cascade: ['persist', 'remove'])]
    // private ?Compra $idProduct = null;


    public function __construct($codigo=null,$nombre=null,$stock=null,$precio=null,$cantidad=null)
    {
        $this->codigo = $codigo;
        $this->nombre = $nombre;
        $this->stock = $stock;
        $this->precio = $precio;
        $this->cantidad = $cantidad;;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCodigo(): ?string
    {
        return $this->codigo;
    }

    public function setCodigo(string $codigo): self
    {
        $this->codigo = $codigo;

        return $this;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getStock(): ?int
    {
        return $this->stock;
    }

    public function setStock(int $stock): self
    {
        $this->stock = $stock;

        return $this;
    }

    public function getTienda(): ?Sale
    {
        return $this->tienda;
    }

    public function setTienda(?Sale $tienda): self
    {
        $this->tienda = $tienda;

        return $this;
    }

    public function getCustomer(): ?Customer
    {
        return $this->customer;
    }

    public function setCustomer(?Customer $customer): self
    {
        $this->customer = $customer;

        return $this;
    }

    public function getPrecio(): ?int
    {
        return $this->precio;
    }

    public function setPrecio(int $precio): self
    {
        $this->precio = $precio;

        return $this;
    }

    public function getCantidad(): ?int
    {
        return $this->cantidad;
    }

    public function setCantidad(int $cantidad): self
    {
        $this->cantidad = $cantidad;

        return $this;
    }

    public function getFechaCompra(): ?\DateTimeInterface
    {
        return $this->fechaCompra;
    }

    public function setFechaCompra(?\DateTimeInterface $fechaCompra): self
    {
        $this->fechaCompra = $fechaCompra;

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
    //         $idCompra->addIdProducto($this);
    //     }

    //     return $this;
    // }

    // public function removeIdCompra(Compras $idCompra): self
    // {
    //     if ($this->idCompra->removeElement($idCompra)) {
    //         $idCompra->removeIdProducto($this);
    //     }

    //     return $this;
    // }

    public function getIdProduct(): ?Compra
    {
        return $this->idProduct;
    }

    public function setIdProduct(?Compra $idProduct): self
    {
        // unset the owning side of the relation if necessary
        if ($idProduct === null && $this->idProduct !== null) {
            $this->idProduct->setIdProduct(null);
        }

        // set the owning side of the relation if necessary
        if ($idProduct !== null && $idProduct->getIdProduct() !== $this) {
            $idProduct->setIdProduct($this);
        }

        $this->idProduct = $idProduct;

        return $this;
    }
}
