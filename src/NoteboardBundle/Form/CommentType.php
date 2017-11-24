<?php
/**
 * Created by PhpStorm.
 * User: steven_chang
 * Date: 2017/11/24
 * Time: 上午 10:45
 */

namespace NoteboardBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class CommentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('commentUsername', TextType::class, array(
                'label' => 'Username : '
        ))
            ->add('commentNotetext', TextType::class, array(
                    'label' => 'Comment : '
            ))
            ->add('Submit', SubmitType::class);
    }
}