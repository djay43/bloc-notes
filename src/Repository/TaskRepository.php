<?php

namespace App\Repository;

use App\Entity\Task;
use App\Entity\TaskSearch;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Query;

/**
 * @method Task|null find($id, $lockMode = null, $lockVersion = null)
 * @method Task|null findOneBy(array $criteria, array $orderBy = null)
 * @method Task[]    findAll()
 * @method Task[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TaskRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Task::class);
    }

    /**
     * @param TaskSearch $search
     * @param string     $order
     *
     * @return \Doctrine\ORM\Query Returns an array of Task objects
     */
    public function findByCreatedAtQuery(TaskSearch $search, $order = 'DESC'): Query
    {
        $query = $this->createQueryBuilder('t')
                      ->orderBy('t.endedAt', $order);

        if ($search->getisCompleted() !== null) {
            $query->andWhere('t.isCompleted = :boolean')
                  ->setParameter('boolean', $search->getisCompleted());
        }
        if ($search->getMinDate()) {
            $query->andWhere('t.endedAt >= :minDate')
                  ->setParameter('minDate', $search->getMinDate());
        }
        if ($search->getMaxDate()) {
            $query->andWhere('t.endedAt <= :maxDate')
                  ->setParameter('maxDate', $search->getMaxDate());
        }

        return $query->getQuery();
    }
}
