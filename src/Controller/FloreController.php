<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Flore;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Contrôleur de gestion de la flore
 *
 * Préfixe de routes : /{_locale}/le-cailloux/flore
 * Affiche les éléments de flore pour la section "Le Cailloux".
 */
#[Route("/{_locale}/le-cailloux/flore", requirements: ["_locale" => "fr|en"], name: "flore_")]
final class FloreController extends AbstractController
{
    /**
     * Route : GET /{_locale}/le-cailloux/flore/
     * Affiche la liste de tous les éléments de flore
     */
    #[Route('/', name: 'index')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $flores = $entityManager
            ->getRepository(Flore::class)
            ->findAll();

        return $this->render('flore/index.html.twig', [
            'flores' => $flores,
        ]);
    }
}
