<?php

namespace App\Entity;

use App\Repository\BookmarkRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Entité Bookmark représentant un marque-page (favori)
 * Relation : Un bookmark peut avoir plusieurs tags (ManyToMany)
 */
#[ORM\Entity(repositoryClass: BookmarkRepository::class)]
class Bookmark
{
    /**
     * Identifiant unique du marque-page
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * URL du marque-page
     */
    #[ORM\Column(length: 255)]
    private ?string $url = null;

    /**
     * Date de création du marque-page
     */
    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $created_date = null;

    /**
     * Commentaire descriptif du marque-page
     */
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $comment = null;

    /**
     * Collection des tags associés au marque-page
     * Relation ManyToMany : Un bookmark peut avoir plusieurs tags
     * @var Collection<int, Tag>
     */
    #[ORM\ManyToMany(targetEntity: Tag::class, inversedBy: 'bookmarks')]
    private Collection $tags;

    /**
     * Constructeur : Initialise la collection de tags
     */
    public function __construct()
    {
        $this->tags = new ArrayCollection();
    }

    /**
     * Retourne l'identifiant du marque-page
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Retourne l'URL du marque-page
     */
    public function getUrl(): ?string
    {
        return $this->url;
    }

    /**
     * Définit l'URL du marque-page
     */
    public function setUrl(string $url): static
    {
        $this->url = $url;
        return $this;
    }

    /**
     * Retourne la date de création du marque-page
     */
    public function getCreatedDate(): ?\DateTimeInterface
    {
        return $this->created_date;
    }

    /**
     * Définit la date de création du marque-page
     */
    public function setCreatedDate(\DateTimeInterface $created_date): static
    {
        $this->created_date = $created_date;
        return $this;
    }

    /**
     * Retourne le commentaire du marque-page
     */
    public function getComment(): ?string
    {
        return $this->comment;
    }

    /**
     * Définit le commentaire du marque-page
     */
    public function setComment(?string $comment): static
    {
        $this->comment = $comment;
        return $this;
    }

    /**
     * Retourne la collection des tags du marque-page
     * @return Collection<int, Tag>
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    /**
     * Ajoute un tag au marque-page
     */
    public function addTag(Tag $tag): static
    {
        if (!$this->tags->contains($tag)) {
            $this->tags->add($tag);
        }
        return $this;
    }

    /**
     * Retire un tag du marque-page
     */
    public function removeTag(Tag $tag): static
    {
        $this->tags->removeElement($tag);
        return $this;
    }
}

