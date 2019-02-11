<?php

namespace App\Http\Controllers;

use Doctrine\ORM\EntityManagerInterface;

use App\Entities\Cliente;
use App\Entities\Contato;
use App\Entities\ContatoFone;
use App\Entities\ContatoEmail;
use App\Repositories\ClienteRepository;
use App\Repositories\CidadeRepository;
use App\Repositories\SegmentoRepository;
use App\Repositories\OperadoraRepository;
use App\Http\Resources\ClienteResource;
use App\Http\Resources\ClientesResource;
use App\Http\Requests\ClienteRequest As Request;

class ClienteController extends Controller
{

    private $repository;
    private $repositorySegmento;
    private $repositoryCidade;
    private $repositoryOperadora;

    public function __construct(EntityManagerInterface $em)
    {
        //$this->middleware('auth:api');        
        $this->repository = new ClienteRepository($em);
        $this->repositorySegmento = new SegmentoRepository($em);
        $this->repositoryCidade = new CidadeRepository($em);
        $this->repositoryOperadora = new OperadoraRepository($em);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $field = ''; $cond = '';
        if (isset($_GET['vid'])) {
            $field = 'id'; $cond = $_GET['vid'];
        }
        if (isset($_GET['vdescricao'])) {
            $field = 'descricao'; $cond = $_GET['vdescricao'];
        }
        
        $cliente = $this->repository->all($field, $cond);

        return new ClientesResource($cliente);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        $data = $request->all(); 

        $segmento = $this->repositorySegmento->find($data['segmento_id']);
        if (!$segmento)
            return response()->json(['message' => 'Segmento nao existe!'], 404);

        $cidade = $this->repositoryCidade->find($data['cidade_id']);
        if (!$cidade)
            return response()->json(['message' => 'Cidade nao existe!'], 404);

        $cliente = new Cliente();
        $cliente->setAll($data);
        $cliente->setCidade($cidade);
        $cliente->setSegmento($segmento);

        $contatos = $data['contatoss'];
        foreach ($contatos as $contato) {            

            $obj = new Contato();
            $obj->setNome($contato['nome']);
            $obj->setCargo($contato['cargo']);            
            
            $fones = $contato['foness'];
            foreach ($fones as $fone) {
                
                $operadora = $this->repositoryOperadora->find($fone['operadora_id']);
                if (!$operadora)
                    return response()->json(['message' => 'Operadora nao existe!'], 404);                
                
                $objf = new ContatoFone();
                $objf->setFone($fone['fone']);
                $objf->setOperadora($operadora);

                $obj->addFone($objf);
            }

            $emils = $contato['emailss'];
            foreach ($emils as $emil) {
                $obje = new ContatoEmail();
                $obje->setEmail($emil['email']);

                $obj->addEmail($obje);
            }

            $cliente->addContato($obj);
        }

        $cliente = $this->repository->persist($cliente);

        $cliente = new ClienteResource($cliente);

        return response()->json($cliente, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $cliente = $this->repository->find($id);   
        
        if (!$cliente)
            return response()->json(['message' => 'Cliente não existe!'], 404);

        return new ClienteResource($cliente);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();  

        $segmento = $this->repositorySegmento->find($data['segmento_id']);
        if (!$segmento)
            return response()->json(['message' => 'Segmento nao existe!'], 404);

        $cidade = $this->repositoryCidade->find($data['cidade_id']);
        if (!$cidade)
            return response()->json(['message' => 'Cidade nao existe!'], 404);

        $cliente = $this->repository->find($id); 
        if (!$cliente)
            return response()->json(['message' => 'cliente não existe!'], 404);            
                

        $cliente->setAll($data);
        $cliente->setCidade($cidade);
        $cliente->setSegmento($segmento);

        //Remove os Conttos para Add novamente
        $cliente->getContato()->clear();

        $contatos = $data['contatoss'];
        foreach ($contatos as $contato) {            

            $obj = new Contato();
            $obj->setNome($contato['nome']);
            $obj->setCargo($contato['cargo']);            
            
            $fones = $contato['foness'];
            foreach ($fones as $fone) {
                
                $operadora = $this->repositoryOperadora->find($fone['operadora_id']);
                if (!$operadora)
                    return response()->json(['message' => 'Operadora nao existe!'], 404);                
                
                $objf = new ContatoFone();
                $objf->setFone($fone['fone']);
                $objf->setOperadora($operadora);

                $obj->addFone($objf);
            }

            $emils = $contato['emailss'];
            foreach ($emils as $emil) {
                $obje = new ContatoEmail();
                $obje->setEmail($emil['email']);

                $obj->addEmail($obje);
            }

            $cliente->addContato($obj);
        }

        $cliente = $this->repository->persist($cliente); 
        
        return new ClienteResource($cliente);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cliente = $this->repository->find($id);   
        
        if (!$cliente)
            return response()->json(['message' => 'Cliente não existe!'], 404);

        $this->repository->remove($cliente); 
        
        return response()->json(['message' => 'Sucess!'], 200);
    }

}
