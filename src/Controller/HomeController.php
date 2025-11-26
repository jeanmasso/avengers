<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

/**
 * Contrôleur de la page d'accueil
 *
 * Gère l'affichage de la page d'accueil et la redirection par défaut vers la locale française.
 */
final class HomeController extends AbstractController
{
    /**
     * Route racine (/)
     * Redirige automatiquement vers la page d'accueil en français
     */
    #[Route('/', name: 'root')]
    public function root(): Response
    {
        return $this->redirectToRoute('home', ['_locale' => 'fr']);
    }

    /**
     * Route de la page d'accueil (/{_locale})
     * Accepte les locales fr et en
     */
    #[Route('/{_locale}', name: 'home', requirements: ['_locale' => 'fr|en'])]
    public function index(): Response
    {
        return $this->render('home/index.html.twig');
    }
}
