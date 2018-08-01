<?php

namespace AppBundle\Form;

use AppBundle\Entity\Comment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('content', TextareaType::class, [
            'attr' => [
                'class' => 'comment-text'
            ]
        ])
            ->add('Comment', SubmitType::class,[
                'attr' => ['class' => 'comment-submit']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class' => Comment::class]);
    }

    public function getBlockPrefix()
    {
        return 'app_bundle_comment_type';
    }
}
