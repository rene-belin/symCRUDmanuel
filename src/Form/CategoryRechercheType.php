<?php

namespace App\Form;

use App\Entity\CategoryRecherche;
use Symfony\Component\Form\AbstractType; 
use Symfony\Component\Form\FormBuilderInterface; 
use Symfony\Component\OptionsResolver\OptionsResolver; 
use Symfony\Bridge\Doctrine\Form\Type\EntityType; 
use App\Entity\Category; 

// Définition de la classe CategoryRechercheType qui étend AbstractType.
class CategoryRechercheType extends AbstractType
{
// Méthode pour construire le formulaire.
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
// Ajout des champs au constructeur de formulaire.
        $builder
// Ajout d'un champ 'category'.
            ->add('category', EntityType::class, [
// Spécification de la classe de l'entité à utiliser, ici 'Category'.
                'class' => Category::class,
// Définition de l'attribut à utiliser pour l'affichage des options, ici 'titre'.
                'choice_label' => 'titre',
// Définition du label du champ qui sera affiché dans le formulaire.
                'label' => 'Catégorie' 
    ]); 
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CategoryRecherche::class,
        ]);
    }
}
