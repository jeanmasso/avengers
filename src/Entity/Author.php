<?php

namespace App\Entity;

use App\Repository\AuthorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Entité Author représentant un auteur
 * Relation : Un auteur peut écrire plusieurs livres (OneToMany)
 */
#[ORM\Entity(repositoryClass: AuthorRepository::class)]
class Author
{
    /**
     * Identifiant unique de l'auteur
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * Prénom de l'auteur
     */
    #[ORM\Column(length: 255)]
    private ?string $firstname = null;

    /**
     * Nom de famille de l'auteur
     */
    #[ORM\Column(length: 255)]
    private ?string $lastname = null;

    /**
     * Collection des livres écrits par cet auteur
     * Relation OneToMany : Un auteur peut avoir plusieurs livres
     * @var Collection<int, Book>
     */
    #[ORM\OneToMany(targetEntity: Book::class, mappedBy: 'author')]
    private Collection $books;

    /**
     * Constructeur : Initialise la collection de livres
     */
    public function __construct()
    {
        $this->books = new ArrayCollection();
    }

    /**
     * Retourne l'identifiant de l'auteur
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Retourne le prénom de l'auteur
     */
    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    /**
     * Définit le prénom de l'auteur
     */
    public function setFirstname(string $firstname): static
    {
        $this->firstname = $firstname;
        return $this;
    }

    /**
     * Retourne le nom de famille de l'auteur
     */
    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    /**
     * Définit le nom de famille de l'auteur
     */
    public function setLastname(string $lastname): static
    {
        $this->lastname = $lastname;
        return $this;
    }

    /**
     * Retourne la collection des livres de l'auteur
     * @return Collection<int, Book>
     */
    public function getBooks(): Collection
    {
        return $this->books;
    }

    /**
     * Ajoute un livre à la collection de l'auteur
     */
    public function addBook(Book $book): static
    {
        if (!$this->books->contains($book)) {
            $this->books->add($book);
            $book->setAuthor($this);
        }
        return $this;
    }

    /**
     * Retire un livre de la collection de l'auteur
     */
    public function removeBook(Book $book): static
    {
        if ($this->books->removeElement($book)) {
            // Supprime la relation côté propriétaire si nécessaire
            if ($book->getAuthor() === $this) {
                $book->setAuthor(null);
            }
        }
        return $this;
    }

    /**
     * Représentation textuelle de l'auteur (prénom + nom)
     * Utilisé dans les formulaires et affichages
     */
    public function __toString(): string
    {
        return $this->firstname . ' ' . $this->lastname;
    }
}

