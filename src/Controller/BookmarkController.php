<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Bookmark;
use Doctrine\ORM\EntityManagerInterface;

final class BookmarkController extends AbstractController{
    #[Route('/bookmark', name: 'app_bookmark')]
    public function index(EntityManagerInterface $entityManager) {
        $bookmarks = $entityManager
            ->getRepository(Bookmark::class)
            ->findAll();

        return $this->render('bookmark/index.html.twig', [
            'bookmarks' => $bookmarks,
        ]);
    }

    #[Route("/bookmark/ajouter", name: "bookmark_ajouter")]
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
}
