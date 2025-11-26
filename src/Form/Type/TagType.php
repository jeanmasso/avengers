<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Tag;

/**
 * Formulaire pour la création et la modification de tags (mots-clés)
 *
 * Permet de saisir le nom d'un tag.
 */
class TagType extends AbstractType
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
            ->add('name', TextType::class, [
                'label' => 'Nom du tag',
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
            'data_class' => Tag::class,
        ]);
    }
}
