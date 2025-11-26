<?php

namespace App\Entity;

use App\Repository\FauneRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Entité Faune
 *
 * Représente un élément de faune (animal) pour la section "Le Cailloux".
 * Contient un nom, une URL de photo et une description.
 */
#[ORM\Entity(repositoryClass: FauneRepository::class)]
class Faune
{
    /**
     * Identifiant unique de l'élément de faune
     *
     * @var int|null
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * Nom de l'animal
     *
     * @var string|null
     */
    #[ORM\Column(length: 255)]
    private ?string $name = null;

    /**
     * URL de la photo de l'animal
     *
     * @var string|null
     */
    #[ORM\Column(length: 500)]
    private ?string $photo_url = null;

    /**
     * Description de l'animal
     *
     * @var string|null
     */
    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    /**
     * Récupère l'identifiant de l'élément de faune
     *
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Récupère le nom de l'animal
     *
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Définit le nom de l'animal
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
     * Récupère l'URL de la photo
     *
     * @return string|null
     */
    public function getPhotoUrl(): ?string
    {
        return $this->photo_url;
    }

    /**
     * Définit l'URL de la photo
     *
     * @param string $photo_url
     * @return static
     */
    public function setPhotoUrl(string $photo_url): static
    {
        $this->photo_url = $photo_url;
        return $this;
    }

    /**
     * Récupère la description de l'animal
     *
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * Définit la description de l'animal
     *
     * @param string $description
     * @return static
     */
    public function setDescription(string $description): static
    {
        $this->description = $description;
        return $this;
    }
}
