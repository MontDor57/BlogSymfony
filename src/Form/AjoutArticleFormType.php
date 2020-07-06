<?php

namespace App\Form;

use App\Entity\Articles;
use App\Entity\MotsCles;
use App\Entity\Categories;
use Symfony\Component\Form\AbstractType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\FormBuilderInterface;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AjoutArticleFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre')
            ->add('contenu', CKEditorType::class)
            ->add('imageFile', VichImageType::class, [
                'label' => 'Image mise en avant'
            ])
            ->add('mots_cles', EntityType::class, [
                'class' => MotsCles::class,
                'label' => 'Mots-Clés',
                'multiple' => true,
                'expanded' => true
            ])
            ->add('categories', EntityType::class, [
                'class' => Categories::class,
                'label' => 'Catégories',
                'multiple' => true,
                'expanded' => true
            ])
            ->add('Publier', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Articles::class,
        ]);
    }
}
