<?php

namespace AppBundle\Form;

use AppBundle\Entity\Post;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title',TextType::class)
                ->add('description',TextareaType::class)
                ->add('image',FileType::class,[
                    'data_class' => null,
                    'label' => 'Post Image'
                ])
                ->add('Post',SubmitType::class,[
                    'attr' => ['class' => 'btn btn-default']
                ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class' => Post::class]);
    }

    public function getBlockPrefix()
    {
        return 'app_bundle_post_type';
    }
}
