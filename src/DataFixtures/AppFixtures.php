<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

/**
 * Fixtures pour charger des données de test dans la base de données
 *
 * Les fixtures permettent de peupler la base avec des données de démonstration.
 * Commande d'exécution : php bin/console doctrine:fixtures:load
 */
class AppFixtures extends Fixture
{
    /**
     * Charge les données de test dans la base de données
     *
     * @param ObjectManager $manager Gestionnaire d'entités Doctrine
     */
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}
