<?php

namespace App\Repository;

use App\Entity\Contrat;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Contrat>
 *
 * @method Contrat|null find($id, $lockMode = null, $lockVersion = null)
 * @method Contrat|null findOneBy(array $criteria, array $orderBy = null)
 * @method Contrat[]    findAll()
 * @method Contrat[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContratRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Contrat::class);
    }

//    /**
//     * @return Contrat[] Returns an array of Contrat objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }
public function findContractsWhereStatueIsFalse(int $id): ?Contrat
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.id = :id')
            ->andWhere('c.statut = :statut')
            ->setParameter('id', $id)
            ->setParameter('statut', false)
            ->getQuery()
            ->getOneOrNullResult();
    }

//    public function findOneBySomeField($value): ?Contrat
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
public function findAllOrderedByAsc(): array
{
    return $this->createQueryBuilder('f')
        ->orderBy('f.id', 'DESC')
       ->setMaxResults(100)
         ->getQuery()
        ->getResult();
}

public function nom($searchQuery, $sort)
{
    $query = $this->createQueryBuilder('p')
        ->leftJoin('p.client', 'c') // Assuming p.client is the relation to client entity
        ->andWhere('c.email LIKE :searchQuery')
        ->setParameter('searchQuery', '%' . $searchQuery . '%');
    
    if ($sort === 'asc') {
        $query->orderBy('p.statut', 'ASC');
    } elseif ($sort === 'desc') {
        $query->orderBy('p.statut', 'DESC');
    }

    return $query->getQuery()->getResult();
}
}
