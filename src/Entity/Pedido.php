<?php

namespace App\Entity;

use App\Repository\PedidoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PedidoRepository::class)]
class Pedido
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $Fecha = null;

    #[ORM\Column(length: 20)]
    private ?string $Estado = null;

    #[ORM\ManyToOne(inversedBy: 'Pedidos')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Cliente $id_Cliente = null;

    #[ORM\OneToMany(mappedBy: 'id_pedido', targetEntity: DetallePedido::class)]
    private Collection $DetallePedidos;

    public function __construct()
    {
        $this->DetallePedidos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFecha(): ?\DateTimeInterface
    {
        return $this->Fecha;
    }

    public function setFecha(\DateTimeInterface $Fecha): static
    {
        $this->Fecha = $Fecha;

        return $this;
    }

    public function getEstado(): ?string
    {
        return $this->Estado;
    }

    public function setEstado(string $Estado): static
    {
        $this->Estado = $Estado;

        return $this;
    }

    public function getIdCliente(): ?Cliente
    {
        return $this->id_Cliente;
    }

    public function setIdCliente(?Cliente $id_Cliente): static
    {
        $this->id_Cliente = $id_Cliente;

        return $this;
    }

    /**
     * @return Collection<int, DetallePedido>
     */
    public function getDetallePedidos(): Collection
    {
        return $this->DetallePedidos;
    }

    public function addDetallePedido(DetallePedido $detallePedido): static
    {
        if (!$this->DetallePedidos->contains($detallePedido)) {
            $this->DetallePedidos->add($detallePedido);
            $detallePedido->setIdPedido($this);
        }

        return $this;
    }

    public function removeDetallePedido(DetallePedido $detallePedido): static
    {
        if ($this->DetallePedidos->removeElement($detallePedido)) {
            // set the owning side to null (unless already changed)
            if ($detallePedido->getIdPedido() === $this) {
                $detallePedido->setIdPedido(null);
            }
        }

        return $this;
    }
}
