<?php

namespace App\Entity;

use App\Repository\CancionRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CancionRepository::class)]
class Cancion
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $titulo = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $genero = null;

    #[ORM\Column(type: Types::TIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $duracion = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Cantante $cantante = null;

    #[ORM\Column(type: Types::INTEGER)]
    private ?int $reproducciones = 0;

    #[ORM\ManyToOne(inversedBy: 'cancion')]
    private ?Disco $disco = null;

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

    public function getGenero(): ?string
    {
        return $this->genero;
    }

    public function setGenero(?string $genero): self
    {
        $this->genero = $genero;

        return $this;
    }

    public function getDuracion(): ?\DateTimeInterface
    {
        return $this->duracion;
    }

    public function setDuracion(?\DateTimeInterface $duracion): self
    {
        $this->duracion = $duracion;

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

    public function setReproducciones($reproducciones)
    {
        $this->reproducciones = $reproducciones;

        return $this;
    }

    public function getReproducciones()
    {
        return $this->reproducciones;
    }

    public function getDisco(): ?Disco
    {
        return $this->disco;
    }

    public function setDisco(?Disco $disco): self
    {
        $this->disco = $disco;

        return $this;
    }

}
