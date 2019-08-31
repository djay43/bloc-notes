<?php

namespace App\Service\Manager;


use App\Entity\TaskSearch;
use App\Repository\TaskRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class Pagination
 *
 * @package App\Service\Manager
 */
class Pagination
{
    /**
     * @param Request            $request
     * @param PaginatorInterface $paginator
     * @param TaskRepository     $taskRepository
     * @param TaskSearch         $taskSearch
     *
     * @return \Knp\Component\Pager\Pagination\PaginationInterface
     */
    public function createPagination(Request $request,
                                     PaginatorInterface $paginator,
                                     TaskRepository $taskRepository,
                                     TaskSearch $taskSearch)
    {
        //set default : limit items per page
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