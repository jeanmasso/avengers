<?php

namespace App\Repository;

use App\Entity\Flore;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Repository pour la gestion de la flore
 *
 * Permet d'accéder aux données des éléments de flore en base de données.
 * Hérite des méthodes standard de ServiceEntityRepository (findAll, find, findBy, etc.).
 *
 * @extends ServiceEntityRepository<Flore>
 */
class FloreRepository extends ServiceEntityRepository
{
    /**
     * Constructeur du repository
     *
     * @param ManagerRegistry $registry Registre Doctrine pour l'accès aux entités
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Flore::class);
    }
}
