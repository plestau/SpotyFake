<?php

namespace App\Entity;

use App\Repository\DiscoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DiscoRepository::class)]
class Disco
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $titulo = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $fecha_lanzamiento = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Cantante $cantante = null;

    #[ORM\OneToMany(mappedBy: 'disco', targetEntity: Cancion::class)]
    private Collection $cancion;

    public function __construct()
    {
        $this->cancion = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitulo(): ?string
    {
        return $this->titulo;
    }

    public function setTitulo(string $titulo): self
    {
        $this->titulo = $titulo;

        return $this;
    }

    public function getFechaLanzamiento(): ?\DateTimeInterface
    {
        return $this->fecha_lanzamiento;
    }

    public function setFechaLanzamiento(?\DateTimeInterface $fecha_lanzamiento): self
    {
        $this->fecha_lanzamiento = $fecha_lanzamiento;

        return $this;
    }

    public function getCantante(): ?Cantante
    {
        return $this->cantante;
    }

    public function setCantante(?Cantante $cantante): self
    {
        $this->cantante = $cantante;

        return $this;
    }

    /**
     * @return Collection<int, Cancion>
     */
    public function getCancion(): Collection
    {
        return $this->cancion;
    }

    public function addCancion(Cancion $cancion): self
    {
        if (!$this->cancion->contains($cancion)) {
            $this->cancion->add($cancion);
            $cancion->setDisco($this);
        }

        return $this;
    }

    public function removeCancion(Cancion $cancion): self
    {
        if ($this->cancion->removeElement($cancion)) {
            // set the owning side to null (unless already changed)
            if ($cancion->getDisco() === $this) {
                $cancion->setDisco(null);
            }
        }

        return $this;
    }
}
