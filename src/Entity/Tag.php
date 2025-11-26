<?php

namespace App\Entity;

use App\Repository\TagRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Entité Tag (Mot-clé)
 *
 * Représente un tag/mot-clé pouvant être associé à plusieurs marque-pages.
 * Relation ManyToMany avec l'entité Bookmark (côté inverse de la relation).
 */
#[ORM\Entity(repositoryClass: TagRepository::class)]
class Tag
{
    /**
     * Identifiant unique du tag
     *
     * @var int|null
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * Nom du tag
     *
     * @var string|null
     */
    #[ORM\Column(length: 255)]
    private ?string $name = null;

    /**
     * Collection de marque-pages associés à ce tag
     *
     * @var Collection<int, Bookmark>
     */
    #[ORM\ManyToMany(targetEntity: Bookmark::class, mappedBy: 'tags')]
    private Collection $bookmarks;

    /**
     * Constructeur - Initialise la collection de bookmarks
     */
    public function __construct()
    {
        $this->bookmarks = new ArrayCollection();
    }

    /**
     * Récupère l'identifiant du tag
     *
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Récupère le nom du tag
     *
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Définit le nom du tag
     *
     * @param string $name
     * @return static
     */
    public function setName(string $name): static
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Récupère la collection de marque-pages associés
     *
     * @return Collection<int, Bookmark>
     */
    public function getBookmarks(): Collection
    {
        return $this->bookmarks;
    }

    /**
     * Ajoute un marque-page à ce tag
     *
     * @param Bookmark $bookmark
     * @return static
     */
    public function addBookmark(Bookmark $bookmark): static
    {
        if (!$this->bookmarks->contains($bookmark)) {
            $this->bookmarks->add($bookmark);
            $bookmark->addTag($this);
        }
        return $this;
    }

    /**
     * Retire un marque-page de ce tag
     *
     * @param Bookmark $bookmark
     * @return static
     */
    public function removeBookmark(Bookmark $bookmark): static
    {
        if ($this->bookmarks->removeElement($bookmark)) {
            $bookmark->removeTag($this);
        }
        return $this;
    }

    /**
     * Représentation textuelle du tag
     * Utilisé pour l'affichage dans les formulaires (EntityType)
     *
     * @return string
     */
    public function __toString(): string
    {
        return $this->name;
    }
}
