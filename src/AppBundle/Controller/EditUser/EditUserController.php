<?php

namespace AppBundle\Controller\EditUser;

use AppBundle\Entity\User;
use AppBundle\Form\UserType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilder;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class EditUserController extends Controller
{

    /**
     * @Route("/edit/password/{id}") name=("pass_edit")
     */
    public function editPassAction($id,Request $request){
        $user = $this->getDoctrine()
            ->getRepository('AppBundle:User')
            ->find($id);

        $oldpass = $this->getUser($id)->getPassword();

        $form = $this->createFormBuilder($user)
            ->add('plainPassword', PasswordType::class,[
                'attr' => [
                    'class' => 'password-field form-control',
                    'style' => 'margin-bottom: 15px'
                ]
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'The password fields must match.',
                'options' => [
                    'attr' => [
                        'class' => 'password-field form-control',
                        'style' => 'margin-bottom: 15px'
                    ]],
                'required' => true,
                'first_options'  => [
                    'label' => 'New Password'
                ],
                'second_options' => [
                    'label' => 'Repeat Password'
                ],
            ])
            ->add('save', SubmitType::class,[
                'label' => 'Done',
                'attr' => [
                    'class' => 'btn btn-primary'
                ]])
            ->getForm();

        $form->handleRequest($request);

        $encoder = $this->get('security.password_encoder');
        $senha = $encoder->encodePassword($user, $user->getPlainPassword());

        echo $senha;
        echo $oldpass;

        if ($form->isSubmitted() && $form->isValid() && $oldpass==$senha) {
            $password = $form['password']->getData();
            $user->setPassword($password);

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $this->addFlash(
                'notice',
                'Uhul!'
            );

            return $this->redirectToRoute('user_list',[
                'user'=>$user
            ]);
        }

        return $this->render('/user/editpass.html.twig',[
            'user'=>$user,
            'form'=>$form->createView()
        ]);
    }
}