<?php

namespace App\Entity;

use App\Repository\SaleRepository;
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
}
