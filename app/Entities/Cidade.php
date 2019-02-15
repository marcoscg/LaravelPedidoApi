<?php

namespace App\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * Cidade
 *
 * @ORM\Table(name="cidade", indexes={@ORM\Index(name="fk_cidade_uf_idx", columns={"uf_id"})})
 * @ORM\Entity
 * @OA\Schema() 
 */
class Cidade extends AbstractEntity
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @OA\Property()
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="descricao", type="string", length=100, nullable=false)
     * @OA\Property()
     */
    protected $descricao;

    /**
     * @var \Uf
     *
     * @ORM\ManyToOne(targetEntity="Uf")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="uf_id", referencedColumnName="id")
     * })
     * @OA\Property(ref="#/components/schemas/Uf")
     */
    protected $uf;

    /**
     * Get the value of id
     *
     * @return  int
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the value of descricao
     *
     * @return  string
     */ 
    public function getDescricao()
    {
        return $this->descricao;
    }

    /**
     * Set the value of descricao
     *
     * @param  string  $descricao
     *
     * @return  self
     */ 
    public function setDescricao(string $descricao)
    {
        $this->descricao = $descricao;

        return $this;
    }

    /**
     * Get the value of uf
     *
     * @return  \Uf
     */ 
    public function getUf()
    {
        return $this->uf;
    }

    /**
     * Set the value of uf
     *
     * @param  \Uf  $uf
     *
     * @return  self
     */ 
    public function setUf($uf)
    {
        $this->uf = $uf;

        return $this;
    }
}
