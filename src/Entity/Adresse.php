<?php

namespace App\Entity;

use App\Repository\AdresseRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * Entité Adresse
 *
 * Représente une adresse géographique (ville et pays).
 * Liée à un employé via une relation OneToOne dans l'entité Employe.
 */
#[ORM\Entity(repositoryClass: AdresseRepository::class)]
class Adresse
{
    /**
     * Identifiant unique de l'adresse
     *
     * @var int|null
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * Ville de l'adresse
     *
     * @var string|null
     */
    #[ORM\Column(length: 255)]
    private ?string $city = null;

    /**
     * Pays de l'adresse
     *
     * @var string|null
     */
    #[ORM\Column(length: 255)]
    private ?string $country = null;

    /**
     * Récupère l'identifiant de l'adresse
     *
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Récupère la ville
     *
     * @return string|null
     */
    public function getCity(): ?string
    {
        return $this->city;
    }

    /**
     * Définit la ville
     *
     * @param string $city
     * @return static
     */
    public function setCity(string $city): static
    {
        $this->city = $city;
        return $this;
    }

    /**
     * Récupère le pays
     *
     * @return string|null
     */
    public function getCountry(): ?string
    {
        return $this->country;
    }

    /**
     * Définit le pays
     *
     * @param string $country
     * @return static
     */
    public function setCountry(string $country): static
    {
        $this->country = $country;
        return $this;
    }
}
