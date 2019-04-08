<?php

namespace App\Repository;


use Doctrine\ORM\EntityRepository;

class StudentRepository extends EntityRepository
{
    public function searchStudent($search = null)
    {
        $builder = $this->createQueryBuilder('s');
        $builder->andWhere(
            $builder->expr()->orX(
                $builder->expr()->like('s.firstname', ':search'),
                $builder->expr()->like('s.lastname', ':search'),
                $builder->expr()->like($builder->expr()->concat('s.lastname', $builder->expr()->concat($builder->expr()->literal(' '), 's.firstname')),
                    ':search'),
                $builder->expr()->like($builder->expr()->concat('s.firstname', $builder->expr()->concat($builder->expr()->literal(' '), 's.lastname')),
                    ':search')
            )
        );

        $builder->setParameter('search', '%'.addcslashes($search, '%_').'%');

        return $builder->getQuery()->getResult();
    }

    public function findStudentWithChar($char)
    {
        $builder = $this->createQueryBuilder('s');
        $builder->andWhere(
            $builder->expr()->orX(
                $builder->expr()->like('s.firstname', ':search'),
                $builder->expr()->like('s.lastname', ':search'),
                $builder->expr()->like($builder->expr()->concat('s.lastname', $builder->expr()->concat($builder->expr()->literal(' '), 's.firstname')),
                    ':search'),
                $builder->expr()->like($builder->expr()->concat('s.firstname', $builder->expr()->concat($builder->expr()->literal(' '), 's.lastname')),
                    ':search')
            )
        );

        $builder->setParameter('search', '%'.addcslashes($char, '%_').'%');

        return $builder->getQuery()->getResult();
    }
}