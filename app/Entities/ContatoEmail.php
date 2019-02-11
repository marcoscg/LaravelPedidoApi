<?php

namespace App\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * ContatoEmail
 *
 * @ORM\Table(name="contato_email", indexes={@ORM\Index(name="fk_email_contato1_idx", columns={"contato_id"})})
 * @ORM\Entity
 */
class ContatoEmail
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
     * @ORM\Column(name="email", type="string", length=100, nullable=false)
     */
    private $email;

    /**
     * @var \Contato
     *
     * @ORM\ManyToOne(targetEntity="Contato", inversedBy="emails")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="contato_id", referencedColumnName="id")
     * })
     */
    private $contato;

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
     * Get the value of email
     *
     * @return  string
     */ 
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @param  string  $email
     *
     * @return  self
     */ 
    public function setEmail(string $email)
    {
        $this->email = $email;

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
}
