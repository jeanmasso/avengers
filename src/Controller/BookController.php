<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Book;
use App\Form\Type\BookType;
use App\Entity\Author;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Contrôleur de gestion des livres
 *
 * Gère toutes les opérations CRUD (Create, Read, Update, Delete) pour les livres,
 * ainsi que des recherches personnalisées et des statistiques.
 * Routes préfixées par /{_locale}/livre pour supporter la localisation (fr|en).
 */
#[Route("/{_locale}/livre", requirements: ["_locale" => "fr|en"], name: "book_")]
final class BookController extends AbstractController{
    /**
     * Affiche la liste de tous les livres
     *
     * @param EntityManagerInterface $entityManager Gestionnaire d'entités Doctrine
     * @return Response Page avec la liste des livres
     */
    #[Route('/', name: 'index')]
    public function index(EntityManagerInterface $entityManager): Response {
        $books = $entityManager
            ->getRepository(Book::class)
            ->findAll();

        return $this->render('book/index.html.twig', [
            'books' => $books,
        ]);
    }

    /**
     * Affiche les détails d'un livre spécifique
     *
     * @param int $bookId Identifiant du livre (par défaut: 1)
     * @param EntityManagerInterface $entityManager Gestionnaire d'entités Doctrine
     * @return Response Page de détail du livre
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException Si le livre n'existe pas
     */
    #[Route("/detail/{bookId<\d+>?1}", name: "detail")]
    public function detailsBook(int $bookId, EntityManagerInterface $entityManager): Response
    {
        $book = $entityManager
            ->getRepository(Book::class)
            ->find($bookId);

        if (!$book) {
            throw $this->createNotFoundException("Aucun livre avec l'id ". $bookId);
        }

        return $this->render('book/detail/index.html.twig', [
            'detailBook' => $book,
        ]);
    }

    /**
     * Recherche les livres dont le titre commence par une lettre donnée
     *
     * @param string $letter Lettre de recherche
     * @param EntityManagerInterface $entityManager Gestionnaire d'entités Doctrine
     * @return Response Page avec les résultats de recherche
     */
    #[Route("/recherche/premiere-lettre/{letter}", name: "search_by_letter")]
    public function searchByFirstLetter(string $letter, EntityManagerInterface $entityManager): Response
    {
        $books = $entityManager
            ->getRepository(Book::class)
            ->findByFirstLetter(strtoupper($letter));

        return $this->render('book/search_results.html.twig', [
            'books' => $books,
            'criteria' => 'Livres commençant par "' . strtoupper($letter) . '"'
        ]);
    }

    /**
     * Recherche les auteurs ayant écrit au moins un nombre minimum de livres
     *
     * @param int $minBooks Nombre minimum de livres
     * @param EntityManagerInterface $entityManager Gestionnaire d'entités Doctrine
     * @return Response Page avec les résultats de recherche
     */
    #[Route("/recherche/auteurs-min-livres/{minBooks<\d+>}", name: "authors_min_books")]
    public function authorsWithMinBooks(int $minBooks, EntityManagerInterface $entityManager): Response
    {
        $authors = $entityManager
            ->getRepository(Book::class)
            ->findAuthorsWithMinBooks($minBooks);

        return $this->render('book/authors_results.html.twig', [
            'authors' => $authors,
            'minBooks' => $minBooks
        ]);
    }

    /**
     * Affiche le nombre total de livres en base de données
     *
     * @param EntityManagerInterface $entityManager Gestionnaire d'entités Doctrine
     * @return Response Page avec les statistiques
     */
    #[Route("/statistiques/nombre-total", name: "count_total")]
    public function countTotal(EntityManagerInterface $entityManager): Response
    {
        $total = $entityManager
            ->getRepository(Book::class)
            ->countAllBooks();

        return $this->render('book/statistics.html.twig', [
            'total' => $total
        ]);
    }

    /**
     * Formulaire d'ajout d'un nouveau livre
     *
     * @param Request $request Requête HTTP
     * @param EntityManagerInterface $entityManager Gestionnaire d'entités Doctrine
     * @return Response Page avec le formulaire ou redirection vers la page de succès
     */
    #[Route("/ajout", name: "ajout")]
    public function ajout(Request $request, EntityManagerInterface $entityManager): Response
    {
        // Création d'un objet que l'on assignera au formulaire
        $book = new Book();

        $form = $this->createForm(BookType::class, $book);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($book);
            $entityManager->flush();

            return $this->redirectToRoute('book_ajout_succes');
        }

        return $this->render('book/add.html.twig', [
            'mon_formulaire' => $form,
        ]);
    }

    /**
     * Page de confirmation après l'ajout d'un livre
     *
     * @return Response Page de succès
     */
    #[Route("/ajout_succes", name: "ajout_succes")]
    public function ajoutSucces(): Response
    {
        return $this->render('book/add_success.html.twig');
    }

    /**
     * Formulaire de modification d'un livre existant
     *
     * @param int $bookId Identifiant du livre à modifier
     * @param Request $request Requête HTTP
     * @param EntityManagerInterface $entityManager Gestionnaire d'entités Doctrine
     * @return Response Page avec le formulaire ou redirection vers la page de détail
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException Si le livre n'existe pas
     */
    #[Route("/modifier/{bookId<\d+>}", name: "modifier")]
    public function modifier(int $bookId, Request $request, EntityManagerInterface $entityManager): Response
    {
        // Récupération du livre existant
        $book = $entityManager
            ->getRepository(Book::class)
            ->find($bookId);

        if (!$book) {
            throw $this->createNotFoundException("Aucun livre avec l'id " . $bookId);
        }

        $form = $this->createForm(BookType::class, $book);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash('success', 'Le livre a été modifié avec succès !');

            return $this->redirectToRoute('book_detail', ['bookId' => $bookId]);
        }

        return $this->render('book/edit.html.twig', [
            'mon_formulaire' => $form,
            'book' => $book,
        ]);
    }
}
