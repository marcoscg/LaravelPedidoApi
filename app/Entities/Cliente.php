<?php

namespace App\Entities;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Cliente
 *
 * @ORM\Table(name="cliente", indexes={@ORM\Index(name="fk_cliente_segmento1_idx", columns={"segmento_id"}), @ORM\Index(name="fk_cliente_cidade1_idx", columns={"cidade_id"})})
 * @ORM\Entity
 */
class Cliente extends AbstractEntity
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
     * @ORM\Column(name="tipo", type="string", length=1, nullable=false, options={"default"="F","fixed"=true})
     */
    private $tipo = 'F';

    /**
     * @var string
     *
     * @ORM\Column(name="cnpj_cpf", type="string", length=14, nullable=false)
     */
    private $cnpjCpf;

    /**
     * @var string
     *
     * @ORM\Column(name="ins_estadual", type="string", length=20, nullable=false)
     */
    private $insEstadual;

    /**
     * @var string
     *
     * @ORM\Column(name="razao_social", type="string", length=100, nullable=false)
     */
    private $razaoSocial;

    /**
     * @var string|null
     *
     * @ORM\Column(name="fantasia", type="string", length=100, nullable=true)
     */
    private $fantasia;

    /**
     * @var string
     *
     * @ORM\Column(name="endereco", type="string", length=100, nullable=false)
     */
    private $endereco;

    /**
     * @var string
     *
     * @ORM\Column(name="numero", type="string", length=10, nullable=false)
     */
    private $numero;

    /**
     * @var string|null
     *
     * @ORM\Column(name="complemento", type="string", length=100, nullable=true)
     */
    private $complemento;

    /**
     * @var string|null
     *
     * @ORM\Column(name="ponto_referencia", type="blob", length=65535, nullable=true)
     */
    private $pontoReferencia;

    /**
     * @var string
     *
     * @ORM\Column(name="bairro", type="string", length=45, nullable=false)
     */
    private $bairro;

    /**
     * @var string|null
     *
     * @ORM\Column(name="cep", type="string", length=8, nullable=true)
     */
    private $cep;

    /**
     * @var string|null
     *
     * @ORM\Column(name="observacao", type="blob", length=65535, nullable=true)
     */
    private $observacao;

    /**
     * @var string|null
     *
     * @ORM\Column(name="data_cadastro", type="datetime", nullable=false)
     */
    private $dataCadastro;

    /**
     * @var \Cidade
     *
     * @ORM\ManyToOne(targetEntity="Cidade")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="cidade_id", referencedColumnName="id")
     * })
     */
    private $cidade;

    /**
     * @var \Segmento
     *
     * @ORM\ManyToOne(targetEntity="Segmento")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="segmento_id", referencedColumnName="id")
     * })
     */
    private $segmento;

    /**
    * @ORM\OneToMany(targetEntity="Contato", mappedBy="cliente", cascade={"persist"}, orphanRemoval=true)
    * @var ArrayCollection|Contato[]
    */
    protected $contatos;

    /**
     * 
     */
    public function __construct()
    {
        $this->contatos = new ArrayCollection;
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
     * Get the value of tipo
     *
     * @return  string
     */ 
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * Set the value of tipo
     *
     * @param  string  $tipo
     *
     * @return  self
     */ 
    public function setTipo(string $tipo)
    {
        $this->tipo = $tipo;

        return $this;
    }

    /**
     * Get the value of cnpjCpf
     *
     * @return  string
     */ 
    public function getCnpjCpf()
    {
        return $this->cnpjCpf;
    }

    /**
     * Set the value of cnpjCpf
     *
     * @param  string  $cnpjCpf
     *
     * @return  self
     */ 
    public function setCnpjCpf(string $cnpjCpf)
    {
        $this->cnpjCpf = $cnpjCpf;

        return $this;
    }

    /**
     * Get the value of insEstadual
     *
     * @return  string
     */ 
    public function getInsEstadual()
    {
        return $this->insEstadual;
    }

    /**
     * Set the value of insEstadual
     *
     * @param  string  $insEstadual
     *
     * @return  self
     */ 
    public function setInsEstadual(string $insEstadual)
    {
        $this->insEstadual = $insEstadual;

        return $this;
    }

    /**
     * Get the value of razaoSocial
     *
     * @return  string
     */ 
    public function getRazaoSocial()
    {
        return $this->razaoSocial;
    }

    /**
     * Set the value of razaoSocial
     *
     * @param  string  $razaoSocial
     *
     * @return  self
     */ 
    public function setRazaoSocial(string $razaoSocial)
    {
        $this->razaoSocial = $razaoSocial;

        return $this;
    }

    /**
     * Get the value of fantasia
     *
     * @return  string|null
     */ 
    public function getFantasia()
    {
        return $this->fantasia;
    }

    /**
     * Set the value of fantasia
     *
     * @param  string|null  $fantasia
     *
     * @return  self
     */ 
    public function setFantasia($fantasia)
    {
        $this->fantasia = $fantasia;

        return $this;
    }

    /**
     * Get the value of endereco
     *
     * @return  string
     */ 
    public function getEndereco()
    {
        return $this->endereco;
    }

    /**
     * Set the value of endereco
     *
     * @param  string  $endereco
     *
     * @return  self
     */ 
    public function setEndereco(string $endereco)
    {
        $this->endereco = $endereco;

        return $this;
    }

    /**
     * Get the value of numero
     *
     * @return  string
     */ 
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * Set the value of numero
     *
     * @param  string  $numero
     *
     * @return  self
     */ 
    public function setNumero(string $numero)
    {
        $this->numero = $numero;

        return $this;
    }

    /**
     * Get the value of complemento
     *
     * @return  string|null
     */ 
    public function getComplemento()
    {
        return $this->complemento;
    }

    /**
     * Set the value of complemento
     *
     * @param  string|null  $complemento
     *
     * @return  self
     */ 
    public function setComplemento($complemento)
    {
        $this->complemento = $complemento;

        return $this;
    }

    /**
     * Get the value of pontoReferencia
     *
     * @return  string|null
     */ 
    public function getPontoReferencia()
    {
        return $this->pontoReferencia;
    }

    /**
     * Set the value of pontoReferencia
     *
     * @param  string|null  $pontoReferencia
     *
     * @return  self
     */ 
    public function setPontoReferencia($pontoReferencia)
    {
        $this->pontoReferencia = $pontoReferencia;

        return $this;
    }

    /**
     * Get the value of bairro
     *
     * @return  string
     */ 
    public function getBairro()
    {
        return $this->bairro;
    }

    /**
     * Set the value of bairro
     *
     * @param  string  $bairro
     *
     * @return  self
     */ 
    public function setBairro(string $bairro)
    {
        $this->bairro = $bairro;

        return $this;
    }

    /**
     * Get the value of cep
     *
     * @return  string|null
     */ 
    public function getCep()
    {
        return $this->cep;
    }

    /**
     * Set the value of cep
     *
     * @param  string|null  $cep
     *
     * @return  self
     */ 
    public function setCep($cep)
    {
        $this->cep = $cep;

        return $this;
    }

    /**
     * Get the value of observacao
     *
     * @return  string|null
     */ 
    public function getObservacao()
    {
        return $this->observacao;
    }

    /**
     * Set the value of observacao
     *
     * @param  string|null  $observacao
     *
     * @return  self
     */ 
    public function setObservacao($observacao)
    {
        $this->observacao = $observacao;

        return $this;
    }

    /**
     * Get the value of dataCadastro
     *
     * @return  \DateTime
     */ 
    public function getDataCadastro()
    {
        return $this->dataCadastro;
    }

    /**
     * Set the value of dataCadastro
     *
     * @param  \DateTime  $dataCadastro
     *
     * @return  self
     */ 
    public function setDataCadastro($dataCadastro)
    {
        $dataCadastro = new \DateTime("now");
        
        $this->dataCadastro = $dataCadastro;

        return $this;
    }

    /**
     * Get the value of cidade
     *
     * @return  \Cidade
     */ 
    public function getCidade()
    {
        return $this->cidade;
    }

    /**
     * Set the value of cidade
     *
     * @param  \Cidade  $cidade
     *
     * @return  self
     */ 
    public function setCidade($cidade)
    {
        $this->cidade = $cidade;

        return $this;
    }

    /**
     * Get the value of segmento
     *
     * @return  \Segmento
     */ 
    public function getSegmento()
    {
        return $this->segmento;
    }

    /**
     * Set the value of segmento
     *
     * @param  \Segmento  $segmento
     *
     * @return  self
     */ 
    public function setSegmento($segmento)
    {
        $this->segmento = $segmento;

        return $this;
    }

    public function addContato(Contato $contato)
    {
        if(!$this->contatos->contains($contato)) {
            $contato->setCliente($this);
            $this->contatos->add($contato);
        }
    }

    public function getContato()
    {
        return $this->contatos;
    }    
}
