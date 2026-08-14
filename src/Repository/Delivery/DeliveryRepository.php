<?php

namespace App\Repository\Delivery;

use App\Entity\Delivery\Delivery;
use App\Repository\Core\CoreRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Delivery>
 *
 * @method Delivery|null find($id, $lockMode = null, $lockVersion = null)
 * @method Delivery|null findOneBy(array $criteria, array $orderBy = null)
 * @method Delivery[]    findAll()
 * @method Delivery[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DeliveryRepository extends ServiceEntityRepository implements CoreRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Delivery::class);
    }

    public function save(Delivery $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Delivery $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function getPaginatedQuery(array $searchFormData = []): Query
    {
        $qb = $this->createQueryBuilder('d')
            ->leftJoin('d.supplier', 's')
            ->leftJoin('d.warehouse', 'w')
            ->leftJoin('d.createdBy', 'u')
            ->addSelect('s', 'w', 'u');
        
        // Търсене по доставчик
        if (!empty($searchFormData['supplier'])) {
            $qb->andWhere('s.name LIKE :supplier')
               ->setParameter('supplier', '%' . $searchFormData['supplier'] . '%');
        }
        
        // Търсене по склад
        if (!empty($searchFormData['warehouse'])) {
            $qb->andWhere('w.id = :warehouse')
               ->setParameter('warehouse', $searchFormData['warehouse']);
        }
        
        // Сортиране по дата на създаване (най-новите първи)
        $qb->orderBy('d.createdAt', 'DESC');
        
        return $qb->getQuery();
    }
} 