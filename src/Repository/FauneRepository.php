<?php

namespace App\Repository;

use App\Entity\Faune;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Repository pour la gestion de la faune
 *
 * Permet d'accéder aux données des éléments de faune en base de données.
 * Hérite des méthodes standard de ServiceEntityRepository (findAll, find, findBy, etc.).
 *
 * @extends ServiceEntityRepository<Faune>
 */
class FauneRepository extends ServiceEntityRepository
{
    /**
     * Constructeur du repository
     *
     * @param ManagerRegistry $registry Registre Doctrine pour l'accès aux entités
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Faune::class);
    }
}
