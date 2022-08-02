<?php

namespace App\Entity;

use App\Repository\CompraRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CompraRepository::class)]
class Compra
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?int $CantidadProductoComprado = null;

    #[ORM\Column(nullable: true)]
    private ?int $valor = null;

    #[ORM\Column(length: 255)]
    private ?string $fechaCompra = null;

    // #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    // private ?\DateTimeInterface $fechaCompra = null;

    // #[ORM\OneToOne(inversedBy: 'idSale', cascade: ['persist', 'remove'])]
    // private ?Sale $idSale = null;

    // #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    // private ?Customer $idCustomer = null;

    // #[ORM\OneToOne(inversedBy: 'idProduct', cascade: ['persist', 'remove'])]
    // private ?Product $idProduct = null;

    // #[ORM\ManyToOne(inversedBy: 'idCompra')]
    // private ?Sale $idCompra = null;


    public function __construct($CantidadProductoComprado=null,$valor=null,$fechaCompra=null,$idCliente=null,$idProducto=null,$idTienda=null)
    {
        $this->CantidadProductoComprado = $CantidadProductoComprado;
        $this->valor = $valor;
        $this->fechaCompra = $fechaCompra;
        $this->idCliente = $idCliente;
        $this->idProducto = $idProducto;
        $this->idTienda = $idTienda;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCantidadProductoComprado(): ?int
    {
        return $this->CantidadProductoComprado;
    }

    public function setCantidadProductoComprado(?int $CantidadProductoComprado): self
    {
        $this->CantidadProductoComprado = $CantidadProductoComprado;

        return $this;
    }

    public function getValor(): ?int
    {
        return $this->valor;
    }

    public function setValor(?int $valor): self
    {
        $this->valor = $valor;

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

    public function getIdSale(): ?Sale
    {
        return $this->idSale;
    }

    public function setIdSale(?Sale $idSale): self
    {
        $this->idSale = $idSale;

        return $this;
    }

    public function getIdCustomer(): ?Customer
    {
        return $this->idCustomer;
    }

    public function setIdCustomer(?Customer $idCustomer): self
    {
        $this->idCustomer = $idCustomer;

        return $this;
    }

    public function getIdProduct(): ?Product
    {
        return $this->idProduct;
    }

    public function setIdProduct(?Product $idProduct): self
    {
        $this->idProduct = $idProduct;

        return $this;
    }

    public function getIdCompra(): ?Sale
    {
        return $this->idCompra;
    }

    public function setIdCompra(?Sale $idCompra): self
    {
        $this->idCompra = $idCompra;

        return $this;
    }


    
}
