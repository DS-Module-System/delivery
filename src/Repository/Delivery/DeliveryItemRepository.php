<?php

namespace App\Repository\Delivery;

use App\Entity\Delivery\DeliveryItem;
use App\Repository\Core\CoreRepository;
use App\Repository\Core\CoreRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends CoreRepository<DeliveryItem>
 *
 * @method DeliveryItem|null find($id, $lockMode = null, $lockVersion = null)
 * @method DeliveryItem|null findOneBy(array $criteria, array $orderBy = null)
 * @method DeliveryItem[]    findAll()
 * @method DeliveryItem[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DeliveryItemRepository extends ServiceEntityRepository implements CoreRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DeliveryItem::class);
    }

    public function getPaginatedQuery(array $searchFormData): Query 
    {  
        $qb = $this->createQueryBuilder('t');

        if(!empty($searchFormData['deliveryId'])) {
            $qb->andWhere('t.delivery = :deliveryId')
                ->setParameter('deliveryId', $searchFormData['deliveryId']);
        }
        
        return $qb->getQuery();
    }

} 