<?php

namespace App\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * ContatoFone
 *
 * @ORM\Table(name="contato_fone", indexes={@ORM\Index(name="fk_fone_contato1_idx", columns={"contato_id"}), @ORM\Index(name="fk_operadora_idx", columns={"operadora_id"})})
 * @ORM\Entity
 */
class ContatoFone
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="fone", type="string", length=20, nullable=false)
     */
    private $fone;

    /**
     * @var \Contato
     *
     * @ORM\ManyToOne(targetEntity="Contato", inversedBy="fones")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="contato_id", referencedColumnName="id")
     * })
     */
    private $contato;

    /**
     * @var \Operadora
     *
     * @ORM\ManyToOne(targetEntity="Operadora")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="operadora_id", referencedColumnName="id")
     * })
     */
    private $operadora;

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
     * Get the value of fone
     *
     * @return  string
     */ 
    public function getFone()
    {
        return $this->fone;
    }

    /**
     * Set the value of fone
     *
     * @param  string  $fone
     *
     * @return  self
     */ 
    public function setFone(string $fone)
    {
        $this->fone = $fone;

        return $this;
    }

    /**
     * Get the value of contato
     *
     * @return  \Contato
     */ 
    public function getContato()
    {
        return $this->contato;
    }

    /**
     * Set the value of contato
     *
     * @param  \Contato  $contato
     *
     * @return  self
     */ 
    public function setContato(Contato $contato)
    {
        $this->contato = $contato;

        return $this;
    }

    /**
     * Get the value of operadora
     *
     * @return  \Operadora
     */ 
    public function getOperadora()
    {
        return $this->operadora;
    }

    /**
     * Set the value of operadora
     *
     * @param  \Operadora  $operadora
     *
     * @return  self
     */ 
    public function setOperadora(Operadora $operadora)
    {
        $this->operadora = $operadora;

        return $this;
    }
}
