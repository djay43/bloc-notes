<?php

namespace App\Service\Manager;


use App\Entity\TaskSearch;
use App\Repository\TaskRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;

class Pagination
{
    public function createPagination(Request $request,
                                     PaginatorInterface $paginator,
                                     TaskRepository $taskRepository,
                                     TaskSearch $taskSearch)
    {
        $limit = 10;
        if ($request->get('count-items')) {
            $limit = $request->get('count-items');
        }
        $pagination = $paginator->paginate(
            $taskRepository->findByCreatedAtQuery($taskSearch),
            $request->query->getInt('page', 1),
            $limit
        );
        return $pagination;
    }
}