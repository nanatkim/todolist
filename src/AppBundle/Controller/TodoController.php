<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Todo;
use AppBundle\Form\TodoType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class TodoController extends Controller
{
    /**
     * @Route("/todo", name="todo_list")
     */
    public function listAction()
    {
        $todos = $this->getDoctrine()
            ->getRepository('AppBundle:Todo')
            ->findAll();


        return $this->render('todo/list.html.twig', [
            'todos' => $todos
        ]);
    }

    /**
     * @Route("/todo/create/{id}", name="todo_create")
     */
    public function createAction(Request $request,$id)
    {
        $todo = new Todo();
        $form = $this->createForm(TodoType::class, $todo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $now = new\DateTime('now');
            $todo->setCreateDate($now);
            $todo->setIdusr($id);

            $em = $this->getDoctrine()->getManager();
            $em->persist($todo);
            $em->flush();

            $this->addFlash(
                'notice',
                'Todo Added!'
            );

            return $this->redirectToRoute('todo_list');
        }
        return $this->render('todo/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/todo/edit/{id}", name="todo_edit")
     */
    public function editAction(Request $request, $id)
    {
        $todo = $this->getDoctrine()
            ->getRepository('AppBundle:Todo')
            ->find($id);

        $now = new\DateTime('now');

        $todo->setCreateDate($now);

        $form = $this->createForm(TodoType::class, $todo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->flush();

            $this->addFlash(
                'notice',
                'Todo Updated!'
            );

            return $this->redirectToRoute('todo_list');
        }

        return $this->render('todo/edit.html.twig', [
            'todo' => $todo,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/todo/details/{id}", name="todo_details")
     */
    public function detailsAction($id)
    {
        $todo = $this->getDoctrine()
            ->getRepository('AppBundle:Todo')
            ->find($id);
        return $this->render('todo/details.html.twig', [
            'todo' => $todo
        ]);
    }

    /**
     * @Route("/todo/delete/{id}", name="todo_delete")
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $todo = $em->getRepository('AppBundle:Todo')->find($id);

        $em->remove($todo);
        $em->flush();

        $this->addFlash(
            'notice',
            'Todo Removed!'
        );

        return $this->redirectToRoute('todo_list');
    }
}

