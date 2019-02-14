<?php

namespace App\Repository;

use App\Entity\Message;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Message|null find($id, $lockMode = null, $lockVersion = null)
 * @method Message|null findOneBy(array $criteria, array $orderBy = null)
 * @method Message[]    findAll()
 * @method Message[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MessageRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Message::class);
    }

    /**
     * @param $idStudent
     * @return Message[] Returns an array of Message objects
     */
    public function findByStudent($idStudent)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.idReceiver = :val')
            ->setParameter('val', $idStudent)
            ->orderBy('m.id', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @param $idReceiver
     * @param $idSender
     * @return Message[] Returns an array of Message objects
     */
    public function findByStudentAsc($idReceiver, $idSender)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.idReceiver = :idReceiver')
            ->andWhere('m.idSender = :idSender')
            ->orWhere('m.idReceiver = :idSender AND m.idSender = :idReceiver')
            ->setParameter('idReceiver', $idReceiver)
            ->setParameter('idSender', $idSender)
            ->orderBy('m.id', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }

    /*
    public function findOneBySomeField($value): ?Message
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
