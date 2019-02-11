<?php

namespace App\Repositories;

use App\Entities\Operadora;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use LaravelDoctrine\ORM\Pagination\Paginatable;

class OperadoraRepository extends EntityRepository
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
        
        parent::__construct($em, $em->getClassMetadata(Operadora::class));
    }

    /**
     * 
     */
    public function all($field = '', $cond = '', $perPage = 5, $pageName = 'page')
    {
        $builder = $this->createQueryBuilder('u');     
        if ($field) {            
            if ($field == 'id') $builder->where('u.id = :cond')->setParameter('cond', $cond);
            if ($field == 'Operadora') $builder->where('u.descricao like :cond')->setParameter('cond', $cond . '%');
            if ($field == 'descricao') $builder->where('u.descricao like :cond')->setParameter('cond', $cond . '%');
        }
        $builder->orderBy('u.id');
    
        return $this->paginate($builder->getQuery(), $perPage, $pageName);
    }    

    /**
    * @param Operadora $operadora
    * @return Operadora
    * @throws \Doctrine\ORM\ORMException
    */
    public function persist(Operadora $operadora)
    {
        $this->getEntityManager()->persist($operadora);
        $this->getEntityManager()->flush();

        return $operadora;
    }

    /**
    * @param Operadora $operadora
    * @throws \Doctrine\ORM\ORMException
    */
    public function remove(Operadora $operadora)
    {
        $this->getEntityManager()->remove($operadora);
        $this->getEntityManager()->flush();

    } 

}