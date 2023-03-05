<?php

namespace App\Entity;

use App\Repository\CantanteRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CantanteRepository::class)]
class Cantante
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nombre = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $fecha_nacimiento = null;

    #[ORM\OneToMany(mappedBy: 'cantante', targetEntity: Cancion::class)]
    private $canciones;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getFechaNacimiento(): ?\DateTimeInterface
    {
        return $this->fecha_nacimiento;
    }

    public function setFechaNacimiento(?\DateTimeInterface $fecha_nacimiento): self
    {
        $this->fecha_nacimiento = $fecha_nacimiento;

        return $this;
    }

    public function getReproduccionesTotales(): int
    {
        $reproduccionesTotales = 0;

        foreach ($this->canciones as $cancion) {
            $reproduccionesTotales += $cancion->getReproducciones();
        }

        return $reproduccionesTotales;
    }
}
