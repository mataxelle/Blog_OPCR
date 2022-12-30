<?php

namespace App\Form;

use App\Entity\Comment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommentFormType extends AbstractType
{
    
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('content', TextareaType::class)
            ->add('isValid', CheckboxType::class, ['required' => false]);

        // end buildForm


    }
    
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(
            [
             'data_class' => Comment::class,
            ]
        );
    }
}
