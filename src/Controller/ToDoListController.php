<?php

namespace App\Controller;

use App\Entity\Task;
use App\Entity\TaskSearch;
use App\Form\TaskSearchType;
use App\Form\TaskType;
use App\Repository\TaskRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ToDoListController extends AbstractController
{
    /**
     * @Route("/", name="front_todo_list")
     * @param TaskRepository     $taskRepository
     *
     * @param Request            $request
     *
     * @param PaginatorInterface $paginator
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(TaskRepository $taskRepository, Request $request, PaginatorInterface $paginator)

    {
        $task = new Task();
        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);

        $taskSearch = new TaskSearch();
        $formSearch = $this->createForm(TaskSearchType::class, $taskSearch);
        $formSearch->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($task);
            $entityManager->flush();
            $this->addFlash('success', 'Votre tâche a bien été créée :-)');

            return $this->redirectToRoute('front_todo_list');
        }
        $limit = 10;
        if($request->get('count-items')){
            $limit = $request->get('count-items');
        }
        $pagination = $paginator->paginate(
            $taskRepository->findByCreatedAtQuery($taskSearch),
            $request->query->getInt('page', 1),
            $limit
        );


        return $this->render('front/todo_list/index.html.twig', [
            'pagination' => $pagination,
            'form'       => $form->createView(),
            'formSearch' => $formSearch->createView()
        ]);
    }

    /**
     * @Route("/{id}", name="task_delete", methods={"DELETE"})
     * @param Request $request
     * @param Task    $task
     *
     * @return Response
     */
    public function delete(Request $request, Task $task): Response
    {
        if ($this->isCsrfTokenValid('delete' . $task->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($task);
            $entityManager->flush();
            $this->addFlash('success', 'Votre tâche a bien été supprimée :-)');
        }

        return $this->redirectToRoute('front_todo_list');
    }

    /**
     * @Route("/edit/{id}", name="front_task_edit", methods={"GET","POST"})
     * @param Request $request
     * @param Task    $task
     *
     * @return Response
     */
    public function edit(Request $request, Task $task): Response
    {
        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'Votre tâche a bien été éditée :-)');

            return $this->redirectToRoute('front_todo_list');
        }

        return $this->render('front/todo_list/edit.html.twig', [
            'task' => $task,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/manage/{id}", options={"expose"=true}, name="handle-task", methods={"GET","POST"})
     * @param Task                   $task
     * @param Request                $request
     *
     * @param EntityManagerInterface $em
     *
     * @return JsonResponse
     */
    public function handleTaskAction(Task $task, Request $request, EntityManagerInterface $em)
    {
        if ($request->get('checked') === 'false') {
            $task->setIsCompleted(true);
            $this->addFlash('success', ' et même <b>Incroyable!</b> Vous avez réalisée une tâche!');

        }
        else {
            $task->setIsCompleted(false);
            $this->addFlash('warning', '
            Il vous reste du boulot, gare à la procrastination!');
        }
        $em->persist($task);
        $em->flush();

        return new JsonResponse($request->get('checked'));
    }
}
