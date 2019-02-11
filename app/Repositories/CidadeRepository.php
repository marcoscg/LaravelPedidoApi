<?php

namespace App\Repositories;

use App\Entities\Cidade;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use LaravelDoctrine\ORM\Pagination\Paginatable;

class CidadeRepository extends EntityRepository
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
        
        parent::__construct($em, $em->getClassMetadata(Cidade::class));
    }

    /**
     * 
     */
    public function all($field = '', $cond = '', $perPage = 10, $pageName = 'page')
    {        
        $builder = $this->createQueryBuilder('c');
        $builder->select(['c', 'u'])->Join('c.uf', 'u');
        if ($field) {
            if ($field == 'id') $builder->where('c.id = :cond')->setParameter('cond', $cond);
            if ($field == 'descricao') $builder->where('c.descricao like :cond')->setParameter('cond', $cond . '%');
        }
        $builder->orderBy('c.descricao');
    
        return $this->paginate($builder->getQuery(), $perPage, $pageName);
    }    

    /**
    * @param Cidade $cidade
    * @return Cidade
    * @throws \Doctrine\ORM\ORMException
    */
    public function persist(Cidade $cidade)
    {
        $this->getEntityManager()->persist($cidade);
        $this->getEntityManager()->flush();

        return $cidade;
    }

    /**
    * @param Cidade $cidade
    * @throws \Doctrine\ORM\ORMException
    */
    public function remove(Cidade $cidade)
    {
        $this->getEntityManager()->remove($cidade);
        $this->getEntityManager()->flush();

    } 

}