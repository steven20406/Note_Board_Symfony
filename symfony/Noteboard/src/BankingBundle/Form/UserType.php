<?php

namespace BankingBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class UserType extends AbstractType
{
    /**
     * Add User
     *
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('username', TextType::class, ['label' => 'User name : ', 'attr' => ['placeholder' => 'Your name']])
                ->add('balance', IntegerType::class, ['label' => 'Initial balance : ', 'attr' => ['placeholder' => 'Save money']])
                ->add('version', HiddenType::class, ['attr' => ['value' => '1']])
                ->add('Submit', SubmitType::class);
    }
}