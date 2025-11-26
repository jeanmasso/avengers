<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Author;

/**
 * Formulaire pour la création et la modification d'auteurs
 *
 * Permet de saisir le prénom et le nom de famille d'un auteur.
 */
class AuthorType extends AbstractType
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
            ->add('firstname', TextType::class, [
                'label' => 'Prénom',
            ])
            ->add('lastname', TextType::class, [
                'label' => 'Nom',
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
            'data_class' => Author::class,
        ]);
    }
}
