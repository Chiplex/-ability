<?php

namespace App\Repository;

use App\Entity\Ability;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Ability|null find($id, $lockMode = null, $lockVersion = null)
 * @method Ability|null findOneBy(array $criteria, array $orderBy = null)
 * @method Ability[]    findAll()
 * @method Ability[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AbilityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Ability::class);
    }

    public function BuscarAbilityPorUser()
    {
        $query = $this->getEntityManager()
            ->createQuery('
                SELECT ability.id, ability.description
                FROM App\Entity\Ability ability
                WHERE ability.user = 3
            ');

        return $query->getResult();
    }

    public function BuscarAbilityPorID($id)
    {
        $query = $this->getEntityManager()
            ->createQuery('
                SELECT ability.id, ability.description
                FROM App\Entity\Ability ability
                WHERE ability.id = :param
            ')
            ->setParameter('param', $id);

        return $query->getSingleResult();
    }

    // /**
    //  * @return Ability[] Returns an array of Ability objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Ability
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
