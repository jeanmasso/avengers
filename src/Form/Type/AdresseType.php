<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Adresse;

/**
 * Formulaire pour la saisie d'une adresse
 *
 * Permet de saisir la ville et le pays.
 * Ce formulaire est intégré dans EmployeType (formulaire imbriqué).
 */
class AdresseType extends AbstractType
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
            ->add('city', TextType::class, [
                'label' => 'Ville',
            ])
            ->add('country', TextType::class, [
                'label' => 'Pays',
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
            'data_class' => Adresse::class,
        ]);
    }
}
