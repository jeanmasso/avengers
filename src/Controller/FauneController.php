<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Faune;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Contrôleur de gestion de la faune
 *
 * Préfixe de routes : /{_locale}/le-cailloux/faune
 * Affiche les éléments de faune pour la section "Le Cailloux".
 */
#[Route("/{_locale}/le-cailloux/faune", requirements: ["_locale" => "fr|en"], name: "faune_")]
final class FauneController extends AbstractController
{
    /**
     * Route : GET /{_locale}/le-cailloux/faune/
     * Affiche la liste de tous les éléments de faune
     */
    #[Route('/', name: 'index')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $faunes = $entityManager
            ->getRepository(Faune::class)
            ->findAll();

        return $this->render('faune/index.html.twig', [
            'faunes' => $faunes,
        ]);
    }
}
