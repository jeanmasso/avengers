<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Book;
use App\Entity\Author;

/**
 * Formulaire pour la création et la modification de livres
 *
 * Permet de saisir le titre, l'année de parution et de sélectionner un auteur
 * parmi ceux existants via un menu déroulant (EntityType).
 */
class BookType extends AbstractType
{
    /**
     * Construction du formulaire avec ses champs
     *
     * @param FormBuilderInterface $builder Interface de construction du formulaire
     * @param array $options Options du formulaire
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre',
            ])
            ->add('year', IntegerType::class, [
                'label' => 'Année de parution',
            ])
            ->add('author', EntityType::class, [
                'class' => Author::class,
                'label' => 'Auteur',
            ])
            ->add('valider', SubmitType::class, [
                'label' => 'Enregistrer',
            ]);
    }

    /**
     * Configuration des options par défaut du formulaire
     *
     * @param OptionsResolver $resolver Résolveur d'options
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Book::class,
        ]);
    }
}
