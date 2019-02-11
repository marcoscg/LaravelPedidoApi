<?php

namespace App\Repositories;

use App\Entities\Segmento;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use LaravelDoctrine\ORM\Pagination\Paginatable;

class SegmentoRepository extends EntityRepository
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
        
        parent::__construct($em, $em->getClassMetadata(Segmento::class));
    }

    /**
     * 
     */
    public function all($field = '', $cond = '', $perPage = 5, $pageName = 'page')
    {
        $builder = $this->createQueryBuilder('u');     
        if ($field) {            
            if ($field == 'id') $builder->where('u.id = :cond')->setParameter('cond', $cond);
            if ($field == 'descricao') $builder->where('u.descricao like :cond')->setParameter('cond', $cond . '%');
        }
        $builder->orderBy('u.id');
    
        return $this->paginate($builder->getQuery(), $perPage, $pageName);
    }    

    /**
    * @param Segmento $segmento
    * @return Segmento
    * @throws \Doctrine\ORM\ORMException
    */
    public function persist(Segmento $segmento)
    {
        $this->getEntityManager()->persist($segmento);
        $this->getEntityManager()->flush();

        return $segmento;
    }

    /**
    * @param Segmento $segmento
    * @throws \Doctrine\ORM\ORMException
    */
    public function remove(Segmento $segmento)
    {
        $this->getEntityManager()->remove($segmento);
        $this->getEntityManager()->flush();

    } 

}