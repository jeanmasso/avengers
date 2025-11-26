<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Author;
use App\Form\Type\AuthorType;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Contrôleur de gestion des auteurs
 *
 * Préfixe de routes : /{_locale}/auteur
 * Gère l'affichage, l'ajout et la modification des auteurs.
 */
#[Route("/{_locale}/auteur", requirements: ["_locale" => "fr|en"], name: "author_")]
final class AuthorController extends AbstractController
{
    /**
     * Route : GET /{_locale}/auteur/
     * Affiche la liste de tous les auteurs
     */
    #[Route('/', name: 'index')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $authors = $entityManager
            ->getRepository(Author::class)
            ->findAll();

        return $this->render('author/index.html.twig', [
            'authors' => $authors,
        ]);
    }

    /**
     * Route : GET /{_locale}/auteur/detail/{authorId}
     * Affiche les détails d'un auteur spécifique (valeur par défaut : 1)
     */
    #[Route("/detail/{authorId<\d+>?1}", name: "detail")]
    public function detailsAuthor(int $authorId, EntityManagerInterface $entityManager): Response
    {
        $author = $entityManager 
            ->getRepository(Author::class) 
            ->find($authorId);

        if (!$author) {
            throw $this->createNotFoundException("Aucun auteur avec l'id ". $authorId);
        }

        return $this->render('author/detail/index.html.twig', [
            'detailAuthor' => $author,
        ]);
    }

    /**
     * Route : GET/POST /{_locale}/auteur/ajout
     * Affiche et traite le formulaire d'ajout d'un nouvel auteur
     */
    #[Route("/ajout", name: "ajout")]
    public function ajout(Request $request, EntityManagerInterface $entityManager): Response
    {
        // Création d'un objet que l'on assignera au formulaire
        $author = new Author();

        $form = $this->createForm(AuthorType::class, $author);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($author);
            $entityManager->flush();

            return $this->redirectToRoute('author_ajout_succes');
        }

        return $this->render('author/add.html.twig', [
            'mon_formulaire' => $form,
        ]);
    }

    /**
     * Route : GET /{_locale}/auteur/ajout_succes
     * Page de confirmation après l'ajout d'un auteur
     */
    #[Route("/ajout_succes", name: "ajout_succes")]
    public function ajoutSucces(): Response
    {
        return $this->render('author/add_success.html.twig');
    }

    /**
     * Route : GET/POST /{_locale}/auteur/modifier/{authorId}
     * Affiche et traite le formulaire de modification d'un auteur existant
     */
    #[Route("/modifier/{authorId<\d+>}", name: "modifier")]
    public function modifier(int $authorId, Request $request, EntityManagerInterface $entityManager): Response
    {
        // Récupération de l'auteur existant
        $author = $entityManager
            ->getRepository(Author::class)
            ->find($authorId);

        if (!$author) {
            throw $this->createNotFoundException("Aucun auteur avec l'id " . $authorId);
        }

        $form = $this->createForm(AuthorType::class, $author);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash('success', 'L\'auteur a été modifié avec succès !');

            return $this->redirectToRoute('author_detail', ['authorId' => $authorId]);
        }

        return $this->render('author/edit.html.twig', [
            'mon_formulaire' => $form,
            'author' => $author,
        ]);
    }
}
