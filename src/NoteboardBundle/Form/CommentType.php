<?php

namespace NoteboardBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class CommentType extends AbstractType {
    /**
     * Add comment form
     *
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('comment_username', TextType::class, ['label' => 'Username : '])
                ->add('comment_notetext', TextType::class, ['label' => 'Comment : '])
                ->add('Submit', SubmitType::class);
    }
}