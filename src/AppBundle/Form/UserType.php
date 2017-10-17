<?php
namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class,[
                'attr'=>[
                    'class' => 'password-field form-control',
                    'style' => 'margin-bottom: 15px'
                ]
            ])
            ->add('email', EmailType::class,[
                'attr'=>[
                    'class' => 'password-field form-control',
                    'style' => 'margin-bottom: 15px'
                ]
            ])
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options' => ['label' => 'Password',
                    'attr'=>[
                        'class' => 'password-field form-control',
                        'style' => 'margin-bottom: 15px'
                    ]],
                'second_options' => ['label' => 'Confirm Password',
                    'attr'=>[
                        'class' => 'password-field form-control',
                        'style' => 'margin-bottom: 15px'
                    ]],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\User',
        ]);
    }
}