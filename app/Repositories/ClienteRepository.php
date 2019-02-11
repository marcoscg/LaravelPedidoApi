<?php

namespace App\Repositories;

use App\Entities\Cliente;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use LaravelDoctrine\ORM\Pagination\Paginatable;

class ClienteRepository extends EntityRepository
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
        
        parent::__construct($em, $em->getClassMetadata(Cliente::class));
    }

    /**
     * 
     */
    public function all($field = '', $cond = '', $perPage = 10, $pageName = 'page')
    {        
        $builder = $this->createQueryBuilder('cli');
        $builder->select(['cli', 'seg', 'cid', 'uf'])->Join('cli.segmento', 'seg')->Join('cli.cidade', 'cid')->Join('cid.uf', 'uf');
        if ($field) {
            if ($field == 'id') $builder->where('cli.id = :cond')->setParameter('cond', $cond);
            if ($field == 'nome') $builder->where('cli.razaoSocial like :cond')->setParameter('cond', $cond . '%');
        }
        $builder->orderBy('cli.razaoSocial');
    
        return $this->paginate($builder->getQuery(), $perPage, $pageName);
    }    

    /**
    * @param Cliente $cliente
    * @return Cliente
    * @throws \Doctrine\ORM\ORMException
    */
    public function persist(Cliente $cliente)
    {
        $this->getEntityManager()->persist($cliente);
        $this->getEntityManager()->flush();

        return $cliente;
    }

    /**
    * @param Cliente $cliente
    * @throws \Doctrine\ORM\ORMException
    */
    public function remove(Cliente $cliente)
    {
        $this->getEntityManager()->remove($cliente);
        $this->getEntityManager()->flush();

    } 

}