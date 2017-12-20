<?php

namespace NoteboardBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class BoarddataType extends AbstractType
{
    /**
     * Add note form
     *
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('username', TextType::class, ['label' => 'User name : '])
                ->add('note', TextType::class, ['label' => 'Note : '])
                ->add('Submit', SubmitType::class);
    }
}