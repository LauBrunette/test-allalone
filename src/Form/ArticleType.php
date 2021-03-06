<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Category;
use App\Entity\Tag;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextareaType::class, [
                'label' => 'Titre'
            ])
            ->add('description', TextareaType::class, [
                'label' => "Description"
            ])
            ->add('createdAt', DateType::class, [
                'widget' => 'single_text',
                'label' => "Date de création",
                'data' => new \DateTime('NOW'),
            ])
            ->add('isPublished', CheckboxType::class, [
                'label' => "Publié ?",
                'data' => true
            ])
            ->add('category', EntityType::class, [
                'label' => 'Catégorie :',
                'class' => Category::class,
                'choice_label' => 'title'
            ])
            ->add('tag', EntityType::class, [
                'label' => 'Tag :',
                'class' => Tag::class,
                'choice_label' => 'name'
            ])
            ->add('submit', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
