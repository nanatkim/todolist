<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Form\UserType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilder;

use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class UserController extends Controller
{
    /**
     * @Route("/user", name="user_list")
     */
    public function userListAction(Request $request)
    {
        $users = $this->getDoctrine()
        ->getRepository('AppBundle:User')
        ->findAll();
        
    return $this->render('user/usrlist.html.twig', [
        'users' => $users
    ]);
    }
     /**
     * @Route("/user/edit/{id}", name="user_edit")
     */
     public function editUsrAction(Request $request,$id)
     {
        $user = $this->getDoctrine()
        ->getRepository('AppBundle:User')
        ->find($id);

        $user->getName();
        $user->getEmail();
        $user->getPassword();

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $em = $this->getDoctrine()->getManager();
            $user = $em->getRepository('AppBundle:User')->find($id);

            $encoder = $this->get('security.password_encoder');
            $password = $encoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);

            $em->flush();

            $this->addFlash(
                'notice',
                'User Edited!'
            );

            return $this->redirectToRoute('user_list');
        }
        return $this->render('user/usredit.html.twig',[
            'user'=>$user,
            'form'=>$form->createView()
        ]);
     }
     /**
     * @Route("/user/details/{id}", name="user_details")
     */
     public function detailsUsrAction($id)
     {
        $user = $this->getDoctrine()
        ->getRepository('AppBundle:User')
        ->find($id);
        return $this->render('user/usrdetails.html.twig',[
            'user' => $user
        ]);
     }
    /**
     * @Route("/user/delete/{id}", name="user_delete")
     */
     public function deleteUserAction($id)
     {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('AppBundle:User')->find($id);

        $em->remove($user);
        $em->flush();

        $this->addFlash(
            'notice',
            'User Removed!'
        );

        return $this->redirectToRoute('user_list');
     }
     /**
     * @Route("/description/{id}", name="user_description")
     */
     public function addDescriptionAction($id, Request $request)
     {
        $user = $this->getDoctrine()
        ->getRepository('AppBundle:User')
        ->find($id);

        $form = $this->createFormBuilder($user)
            ->add('aboutme', TextareaType::class,['attr' => ['class' => 'form-control','style' => 'margin-bottom: 15px']])
            ->add('save', SubmitType::class,['label' => 'Add Description','attr' => ['class' => 'btn btn-primary']])
            ->getForm();
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $aboutme = $form['aboutme']->getData();
            $user->setAboutme($aboutme);

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('todo_list',[
                'user'=>$user
                ]);
        }
        return $this->render('/user/usredit.html.twig',[
            'user'=>$user,
            'form'=>$form->createView()
        ]);
     }
}

