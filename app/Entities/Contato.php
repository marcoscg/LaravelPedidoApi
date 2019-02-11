<?php

namespace App\Entities;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Contato
 *
 * @ORM\Table(name="contato", indexes={@ORM\Index(name="fk_contato_cliente1_idx", columns={"cliente_id"})})
 * @ORM\Entity
 */
class Contato
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
     * @ORM\Column(name="nome", type="string", length=100, nullable=false)
     */
    private $nome;

    /**
     * @var string|null
     *
     * @ORM\Column(name="cargo", type="string", length=100, nullable=true)
     */
    private $cargo;

    /**
    * @ORM\ManyToOne(targetEntity="Cliente", inversedBy="contatos")
    * @var Cliente
    */
    protected $cliente;

    /**
    * @ORM\OneToMany(targetEntity="ContatoFone", mappedBy="contato", cascade={"persist"})
    * @var ArrayCollection|ContatoFone[]
    */
    protected $fones;
    
    /**
    * @ORM\OneToMany(targetEntity="ContatoEmail", mappedBy="contato", cascade={"persist"})
    * @var ArrayCollection|ContatoEmail[]
    */
    protected $emails;
    
    /**
     * 
     */
    public function __construct()
    {
        $this->fones = new ArrayCollection;
        $this->emails = new ArrayCollection;
    }      

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
     * Get the value of nome
     *
     * @return  string
     */ 
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * Set the value of nome
     *
     * @param  string  $nome
     *
     * @return  self
     */ 
    public function setNome(string $nome)
    {
        $this->nome = $nome;

        return $this;
    }

    /**
     * Get the value of cargo
     *
     * @return  string|null
     */ 
    public function getCargo()
    {
        return $this->cargo;
    }

    /**
     * Set the value of cargo
     *
     * @param  string|null  $cargo
     *
     * @return  self
     */ 
    public function setCargo($cargo)
    {
        $this->cargo = $cargo;

        return $this;
    }

    /**
     * Get the value of cliente
     *
     * @return  Scientist
     */ 
    public function getCliente()
    {
        return $this->cliente;
    }

    /**
     * Set the value of cliente
     *
     * @param  Scientist  $cliente
     *
     * @return  self
     */ 
    public function setCliente(Cliente $cliente)
    {
        $this->cliente = $cliente;

        return $this;
    }

    /**
     * 
     */
    public function addFone(ContatoFone $fone)
    {
        if(!$this->fones->contains($fone)) {
            $fone->setContato($this);
            $this->fones->add($fone);
        }
    }

    /**
     * 
     */
    public function getFone()
    {
        return $this->fones;
    }    
    
    /**
     * 
     */
    public function addEmail(ContatoEmail $email)
    {
        if(!$this->emails->contains($email)) {
            $email->setContato($this);
            $this->emails->add($email);
        }
    }

    /**
     * 
     */
    public function getEmail()
    {
        return $this->emails;
    }    
}
