<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Bookmark;
use App\Form\Type\BookmarkType;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Contrôleur de gestion des marque-pages (bookmarks)
 *
 * Préfixe de routes : /{_locale}/marque-page
 * Gère l'affichage, l'ajout et la modification des marque-pages avec leurs tags.
 */
#[Route("/{_locale}/marque-page", requirements: ["_locale" => "fr|en"], name: "bookmark_")]
final class BookmarkController extends AbstractController
{
    /**
     * Route : GET /{_locale}/marque-page/
     * Affiche la liste de tous les marque-pages
     */
    #[Route('/', name: 'index')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $bookmarks = $entityManager
            ->getRepository(Bookmark::class)
            ->findAll();

        return $this->render('bookmark/index.html.twig', [
            'bookmarks' => $bookmarks,
        ]);
    }

    /**
     * Route : GET /{_locale}/marque-page/detail/{bookmarkId}
     * Affiche les détails d'un marque-page spécifique (valeur par défaut : 1)
     */
    #[Route("/detail/{bookmarkId<\d+>?1}", name: "detail")]
    public function detailsBookmark(int $bookmarkId, EntityManagerInterface $entityManager): Response
    {
        $bookmark = $entityManager 
            ->getRepository(Bookmark::class) 
            ->find($bookmarkId);

        if (!$bookmark) {
            throw $this->createNotFoundException("Aucun marque-page avec l'id ". $bookmarkId);
        }

        return $this->render('bookmark/detail/index.html.twig', [
            'detailBookmark' => $bookmark,
            'createdDateBookmark' => $bookmark->getCreatedDate()
        ]);
    }

    /**
     * Route : GET/POST /{_locale}/marque-page/ajout
     * Affiche et traite le formulaire d'ajout d'un nouveau marque-page
     */
    #[Route("/ajout", name: "ajout")]
    public function ajout(Request $request, EntityManagerInterface $entityManager): Response
    {
        $bookmark = new Bookmark();

        $form = $this->createForm(BookmarkType::class, $bookmark);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($bookmark);
            $entityManager->flush();

            return $this->redirectToRoute('bookmark_ajout_succes');
        }

        return $this->render('bookmark/add.html.twig', [
            'mon_formulaire' => $form,
        ]);
    }

    /**
     * Route : GET /{_locale}/marque-page/ajout_succes
     * Page de confirmation après l'ajout d'un marque-page
     */
    #[Route("/ajout_succes", name: "ajout_succes")]
    public function ajoutSucces(): Response
    {
        return $this->render('bookmark/add_success.html.twig');
    }

    /**
     * Route : GET/POST /{_locale}/marque-page/modifier/{bookmarkId}
     * Affiche et traite le formulaire de modification d'un marque-page existant
     */
    #[Route("/modifier/{bookmarkId<\d+>}", name: "modifier")]
    public function modifier(int $bookmarkId, Request $request, EntityManagerInterface $entityManager): Response
    {
        $bookmark = $entityManager
            ->getRepository(Bookmark::class)
            ->find($bookmarkId);

        if (!$bookmark) {
            throw $this->createNotFoundException("Aucun marque-page avec l'id " . $bookmarkId);
        }

        $form = $this->createForm(BookmarkType::class, $bookmark);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash('success', 'Le marque-page a été modifié avec succès !');

            return $this->redirectToRoute('bookmark_detail', ['bookmarkId' => $bookmarkId]);
        }

        return $this->render('bookmark/edit.html.twig', [
            'mon_formulaire' => $form,
            'bookmark' => $bookmark,
        ]);
    }
}
