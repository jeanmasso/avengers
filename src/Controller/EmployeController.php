<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Employe;
use App\Form\Type\EmployeType;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Contrôleur de gestion des employés
 *
 * Préfixe de routes : /{_locale}/employe
 * Gère l'ajout d'employés avec formulaire imbriqué (adresse incluse).
 */
#[Route("/{_locale}/employe", requirements: ["_locale" => "fr|en"], name: "employe_")]
final class EmployeController extends AbstractController
{
    /**
     * Route : GET/POST /{_locale}/employe/ajout
     * Affiche et traite le formulaire d'ajout d'un employé avec son adresse
     */
    #[Route("/ajout", name: "ajout")]
    public function ajout(Request $request, EntityManagerInterface $entityManager): Response
    {
        $employe = new Employe();

        $form = $this->createForm(EmployeType::class, $employe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($employe);
            $entityManager->flush();

            $this->addFlash('success', 'L\'employé a été ajouté avec succès !');

            return $this->redirectToRoute('employe_ajout');
        }

        return $this->render('employe/add.html.twig', [
            'mon_formulaire' => $form,
        ]);
    }
}
