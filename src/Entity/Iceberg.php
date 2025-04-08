<?php

namespace App\Entity;

use App\Repository\IcebergRepository;
use App\Validator\BanWord;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: IcebergRepository::class)]
#[UniqueEntity('titre')]
#[UniqueEntity('slug')]
class Iceberg
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\Length(min : 10, groups: ['Extra'])]
    #[BanWord]
    private ?string $titre = null;

    #[ORM\Column(length: 255)]
    #[Assert\Length(min : 5)]
    #[Assert\Regex('/^[a-z0-9]+(?:-[a-z0-9]+)*$/', message: "Un slug ne peut pas contenir de caractères spéciaux")]
    private ?string $slug = '';

    #[ORM\Column(length: 255)]
    private ?string $text = '';

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): static
    {
        $this->titre = $titre;

        return $this;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): static
    {
        $this->text = $text;

        return $this;
    }
}