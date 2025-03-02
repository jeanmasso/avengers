<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Bookmark;
use Doctrine\ORM\EntityManagerInterface;

#[Route("/marque-page", requirements: ["_locale" => "en|es|fr"], name: "bookmark_")]
final class BookmarkController extends AbstractController{
    #[Route('/', name: 'index')]
    public function index(EntityManagerInterface $entityManager) {
        $bookmarks = $entityManager
            ->getRepository(Bookmark::class)
            ->findAll();

        return $this->render('bookmark/index.html.twig', [
            'bookmarks' => $bookmarks,
        ]);
    }

    #[Route("/ajouter", name: "add")]
    public function addBookmark(EntityManagerInterface $entityManager): Response {

        $newData = [
            ["url" => "https://symfony.com/", "comment" => "Symfony"],
            ["url" => "https://www.qwant.com/", "comment" => "Qwant"],
            ["url" => "https://getbootstrap.com/", "comment" => "Bootstrap"]
        ];

        foreach ($newData as $data) {
            $bookmark = new Bookmark();
            $bookmark->setUrl($data["url"]);
            $bookmark->setComment($data["comment"]);
            $bookmark->setCreatedDate(new \DateTime());

            $entityManager->persist($bookmark);
        }

        $entityManager->flush();
        return new Response("Marques-pages sauvegardés.");
    }

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
}
