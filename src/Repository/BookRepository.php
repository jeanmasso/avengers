<?php

namespace App\Repository;

use App\Entity\Book;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Repository pour la gestion des livres
 *
 * Contient les requêtes personnalisées pour la recherche et les statistiques de livres.
 * Utilise Doctrine DBAL 3.x pour exécuter des requêtes SQL natives optimisées.
 *
 * @extends ServiceEntityRepository<Book>
 */
class BookRepository extends ServiceEntityRepository
{
    /**
     * Constructeur du repository
     *
     * @param ManagerRegistry $registry Registre Doctrine pour l'accès aux entités
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Book::class);
    }

    /**
     * Retourne la liste des livres dont le titre commence par une lettre donnée
     *
     * Effectue une jointure avec la table author pour récupérer les informations de l'auteur.
     * Utilise DBAL 3.x: executeQuery() retourne un Result avec fetchAllAssociative().
     *
     * @param string $letter La lettre de recherche (sera convertie en MAJUSCULE)
     * @return array Tableau associatif avec id, title, year, firstname, lastname
     */
    public function findByFirstLetter(string $letter): array
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = '
            SELECT b.id, b.title, b.year, a.firstname, a.lastname
            FROM book b
            INNER JOIN author a ON b.author_id = a.id
            WHERE b.title LIKE :letter
            ORDER BY b.title ASC
        ';
        $stmt = $conn->prepare($sql);
        $result = $stmt->executeQuery(['letter' => $letter . '%']);
        return $result->fetchAllAssociative();
    }

    /**
     * Retourne les auteurs ayant écrit plus d'un certain nombre de livres
     *
     * Utilise GROUP BY et HAVING pour compter les livres par auteur.
     * Les résultats sont triés par nombre de livres décroissant, puis par nom d'auteur.
     *
     * @param int $minBooks Nombre minimum de livres requis
     * @return array Tableau associatif avec id, firstname, lastname, nb_books
     */
    public function findAuthorsWithMinBooks(int $minBooks): array
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = '
            SELECT a.id, a.firstname, a.lastname, COUNT(b.id) as nb_books
            FROM author a
            INNER JOIN book b ON b.author_id = a.id
            GROUP BY a.id, a.firstname, a.lastname
            HAVING COUNT(b.id) >= :minBooks
            ORDER BY nb_books DESC, a.lastname ASC
        ';
        $stmt = $conn->prepare($sql);
        $result = $stmt->executeQuery(['minBooks' => $minBooks]);
        return $result->fetchAllAssociative();
    }

    /**
     * Retourne le nombre total de livres présents en base
     *
     * Utilise fetchOne() pour récupérer directement la valeur du COUNT.
     *
     * @return int Nombre total de livres
     */
    public function countAllBooks(): int
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = 'SELECT COUNT(*) as total FROM book';
        $stmt = $conn->prepare($sql);
        $result = $stmt->executeQuery();
        return (int) $result->fetchOne();
    }
}
