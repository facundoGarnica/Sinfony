<?php

namespace App\Entity;

use App\Repository\ClienteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClienteRepository::class)]
class Cliente
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $Nombre = null;

    #[ORM\Column(length: 100)]
    private ?string $Mail = null;

    #[ORM\Column(length: 255)]
    private ?string $Direccion = null;

    #[ORM\OneToMany(mappedBy: 'id_Cliente', targetEntity: Pedido::class, orphanRemoval: true)]
    private Collection $Pedidos;

    public function __construct()
    {
        $this->Pedidos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->Nombre;
    }

    public function setNombre(string $Nombre): static
    {
        $this->Nombre = $Nombre;

        return $this;
    }

    public function getMail(): ?string
    {
        return $this->Mail;
    }

    public function setMail(string $Mail): static
    {
        $this->Mail = $Mail;

        return $this;
    }

    public function getDireccion(): ?string
    {
        return $this->Direccion;
    }

    public function setDireccion(string $Direccion): static
    {
        $this->Direccion = $Direccion;

        return $this;
    }

    /**
     * @return Collection<int, Pedido>
     */
    public function getPedidos(): Collection
    {
        return $this->Pedidos;
    }

    public function addPedido(Pedido $pedido): static
    {
        if (!$this->Pedidos->contains($pedido)) {
            $this->Pedidos->add($pedido);
            $pedido->setIdCliente($this);
        }

        return $this;
    }

    public function removePedido(Pedido $pedido): static
    {
        if ($this->Pedidos->removeElement($pedido)) {
            // set the owning side to null (unless already changed)
            if ($pedido->getIdCliente() === $this) {
                $pedido->setIdCliente(null);
            }
        }

        return $this;
    }
}
