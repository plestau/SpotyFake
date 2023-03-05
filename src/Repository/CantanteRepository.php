<?php

namespace App\Repository;

use App\Entity\Cantante;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Cantante>
 *
 * @method Cantante|null find($id, $lockMode = null, $lockVersion = null)
 * @method Cantante|null findOneBy(array $criteria, array $orderBy = null)
 * @method Cantante[]    findAll()
 * @method Cantante[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CantanteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Cantante::class);
    }

    public function save(Cantante $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Cantante $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function buscarPorNombre($query)
    {
        $qb = $this->createQueryBuilder('c');
        $qb->where('c.nombre LIKE :query')
           ->setParameter('query', '%'.$query.'%');

        return $qb->getQuery()->getResult();
    }

//    /**
//     * @return Cantante[] Returns an array of Cantante objects
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

//    public function findOneBySomeField($value): ?Cantante
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
