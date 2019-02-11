<?php

namespace App\Repositories;

use App\Entities\Uf;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use LaravelDoctrine\ORM\Pagination\Paginatable;

class UfRepository extends EntityRepository
{
    use Paginatable;
    
    private $em;    
    
    /**
    * ScientistRepository constructor.
    * @param EntityManagerInterface $em
    */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        
        parent::__construct($em, $em->getClassMetadata(Uf::class));
    }

    /**
     * 
     */
    public function all($field = '', $cond = '', $perPage = 5, $pageName = 'page')
    {
        $builder = $this->createQueryBuilder('u');     
        if ($field) {            
            if ($field == 'id') $builder->where('u.id = :cond')->setParameter('cond', $cond);
            if ($field == 'uf') $builder->where('u.descricao like :cond')->setParameter('cond', $cond . '%');
            if ($field == 'descricao') $builder->where('u.descricao like :cond')->setParameter('cond', $cond . '%');
        }
        $builder->orderBy('u.id');
    
        return $this->paginate($builder->getQuery(), $perPage, $pageName);
    }    

    /**
    * @param Uf $uf
    * @return Uf
    * @throws \Doctrine\ORM\ORMException
    */
    public function persist(Uf $uf)
    {
        $this->getEntityManager()->persist($uf);
        $this->getEntityManager()->flush();

        return $uf;
    }

    /**
    * @param Uf $uf
    * @throws \Doctrine\ORM\ORMException
    */
    public function remove(Uf $uf)
    {
        $this->getEntityManager()->remove($uf);
        $this->getEntityManager()->flush();

    } 

}