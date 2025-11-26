<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Bookmark;
use App\Entity\Tag;

/**
 * Formulaire pour la création et la modification de marque-pages (bookmarks)
 *
 * Permet de saisir une URL, un commentaire et de sélectionner plusieurs tags
 * via une liste de sélection multiple (EntityType avec multiple=true).
 */
class BookmarkType extends AbstractType
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
            ->add('url', TextType::class, [
                'label' => 'URL',
            ])
            ->add('comment', TextareaType::class, [
                'label' => 'Commentaire',
                'required' => false,
            ])
            ->add('tags', EntityType::class, [
                'class' => Tag::class,
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => false,
                'label' => 'Tags',
                'required' => false,
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
            'data_class' => Bookmark::class,
        ]);
    }
}
