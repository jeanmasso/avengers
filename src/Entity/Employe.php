<?php

namespace App\Entity;

use App\Repository\EmployeRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Entité Employe (Employé)
 *
 * Représente un employé avec son prénom, nom et adresse.
 * Relation OneToOne avec l'entité Adresse (cascade persist et remove).
 * Exemple de formulaire imbriqué : l'adresse est intégrée dans le formulaire de l'employé.
 */
#[ORM\Entity(repositoryClass: EmployeRepository::class)]
class Employe
{
    /**
     * Identifiant unique de l'employé
     *
     * @var int|null
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * Prénom de l'employé
     *
     * @var string|null
     */
    #[ORM\Column(length: 255)]
    private ?string $firstname = null;

    /**
     * Nom de famille de l'employé
     *
     * @var string|null
     */
    #[ORM\Column(length: 255)]
    private ?string $lastname = null;

    /**
     * Adresse de l'employé
     * Relation OneToOne avec cascade persist et remove
     *
     * @var Adresse|null
     */
    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[Assert\Type(type: "App\Entity\Adresse")]
    #[Assert\Valid]
    private ?Adresse $adresse = null;

    /**
     * Récupère l'identifiant de l'employé
     *
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Récupère le prénom de l'employé
     *
     * @return string|null
     */
    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    /**
     * Définit le prénom de l'employé
     *
     * @param string $firstname
     * @return static
     */
    public function setFirstname(string $firstname): static
    {
        $this->firstname = $firstname;
        return $this;
    }

    /**
     * Récupère le nom de famille de l'employé
     *
     * @return string|null
     */
    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    /**
     * Définit le nom de famille de l'employé
     *
     * @param string $lastname
     * @return static
     */
    public function setLastname(string $lastname): static
    {
        $this->lastname = $lastname;
        return $this;
    }

    /**
     * Récupère l'adresse de l'employé
     *
     * @return Adresse|null
     */
    public function getAdresse(): ?Adresse
    {
        return $this->adresse;
    }

    /**
     * Définit l'adresse de l'employé
     *
     * @param Adresse|null $adresse
     * @return static
     */
    public function setAdresse(?Adresse $adresse): static
    {
        $this->adresse = $adresse;
        return $this;
    }
}
