<?php
/**
 * Created by PhpStorm.
 * User: nxt-11
 * Date: 03/10/17
 * Time: 16:26
 */

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TodoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',TextType::class,[
                'attr' => [
                    'class' => 'form-control',
                    'style' => 'margin-bottom:15px'
                ]
            ])
            ->add('category',TextType::class,[
                'attr' => [
                    'class' => 'form-control',
                    'style' => 'margin-bottom:15px'
                ]
            ])
            ->add('description',TextareaType::class,[
                'attr' => [
                    'class' => 'form-control',
                    'style' => 'margin-bottom:15px'
                ]
            ])
            ->add('priority',ChoiceType::class,[
                'choices' => [
                    'Low' => 'Low',
                    'Normal' => 'Normal',
                    'High' => 'High'
                ],
                'attr' => [
                    'class' => 'form-control',
                    'style' => 'margin-bottom:15px'
                ]])
            ->add('due_date',DateTimeType::class,[
                'attr'=>[
                    'style' => 'margin-bottom:15px;display:flex;'
                ]
            ])
            ->add('submit',SubmitType::class,[
                'label' => 'Done',
                'attr' => [
                    'class' => 'btn btn-primary',
                    'style' => 'margin-bottom:15px'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\Todo',
        ]);
    }
}