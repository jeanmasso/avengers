<?php

namespace App\Entity;

use App\Repository\BookRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Entité Book représentant un livre
 * Relation : Un livre appartient à un seul auteur (ManyToOne)
 */
#[ORM\Entity(repositoryClass: BookRepository::class)]
class Book
{
    /**
     * Identifiant unique du livre
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * Auteur du livre
     * Relation ManyToOne : Plusieurs livres peuvent avoir le même auteur
     */
    #[ORM\ManyToOne(targetEntity: "App\Entity\Author", inversedBy: "books")]
    #[Assert\Type(type: "App\Entity\Author")]
    #[Assert\Valid]
    private ?Author $author = null;

    /**
     * Titre du livre
     */
    #[ORM\Column(length: 255)]
    private ?string $title = null;

    /**
     * Année de parution du livre
     */
    #[ORM\Column(length: 255)]
    private ?string $year = null;

    /**
     * Retourne l'identifiant du livre
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Retourne l'auteur du livre
     */
    public function getAuthor(): ?Author
    {
        return $this->author;
    }

    /**
     * Définit l'auteur du livre
     */
    public function setAuthor(?Author $author): static
    {
        $this->author = $author;
        return $this;
    }

    /**
     * Retourne le titre du livre
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * Définit le titre du livre
     */
    public function setTitle(string $title): static
    {
        $this->title = $title;
        return $this;
    }

    /**
     * Retourne l'année de parution du livre
     */
    public function getYear(): ?string
    {
        return $this->year;
    }

    /**
     * Définit l'année de parution du livre
     */
    public function setYear(string $year): static
    {
        $this->year = $year;
        return $this;
    }
}

