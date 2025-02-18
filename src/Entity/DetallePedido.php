<?php

namespace App\Entity;

use App\Repository\DetallePedidoRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DetallePedidoRepository::class)]
class DetallePedido
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 7, scale: 2)]
    private ?string $Subtotal = null;

    #[ORM\ManyToOne(inversedBy: 'DetallePedidos')]
    private ?Pedido $id_pedido = null;

    #[ORM\ManyToOne(inversedBy: 'DetallePedidos')]
    private ?Producto $id_producto = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSubtotal(): ?string
    {
        return $this->Subtotal;
    }

    public function setSubtotal(string $Subtotal): static
    {
        $this->Subtotal = $Subtotal;

        return $this;
    }

    public function getIdPedido(): ?Pedido
    {
        return $this->id_pedido;
    }

    public function setIdPedido(?Pedido $id_pedido): static
    {
        $this->id_pedido = $id_pedido;

        return $this;
    }

    public function getIdProducto(): ?Producto
    {
        return $this->id_producto;
    }

    public function setIdProducto(?Producto $id_producto): static
    {
        $this->id_producto = $id_producto;

        return $this;
    }
}
