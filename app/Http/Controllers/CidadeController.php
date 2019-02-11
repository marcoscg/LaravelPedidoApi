<?php

namespace App\Http\Controllers;

use Doctrine\ORM\EntityManagerInterface;

use App\Entities\Cidade;
use App\Repositories\CidadeRepository;
use App\Repositories\UfRepository;
use App\Http\Resources\CidadeResource;
use App\Http\Resources\CidadesResource;
use App\Http\Requests\CidadeRequest As Request;

class CidadeController extends Controller
{

    private $repository;
    private $repositoryUf;

    public function __construct(EntityManagerInterface $em)
    {
        //$this->middleware('auth:api');        
        $this->repository = new CidadeRepository($em);
        $this->repositoryUf = new UfRepository($em);
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
        
        $cidade = $this->repository->all($field, $cond);

        return new CidadesResource($cidade);
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

        $uf = $this->repositoryUf->find($data['uf_id']);
        if (!$uf)
            return response()->json(['message' => 'UF nao existe!'], 404);         

        $cidade = new Cidade();
        $cidade->setAll($data);
        $cidade->setUf($uf);

        $cidade = $this->repository->persist($cidade);

        $cidade = new CidadeResource($cidade);

        return response()->json($cidade, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $cidade = $this->repository->find($id);   
        
        if (!$cidade)
            return response()->json(['message' => 'Cidade não existe!'], 404);

        return new CidadeResource($cidade);
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

        $cidade = $this->repository->find($id); 
        if (!$cidade)
            return response()->json(['message' => 'Cidade não existe!'], 404);        
        
        $uf = $this->repositoryUf->find($data['uf_id']);
        if (!$uf)
            return response()->json(['message' => 'UF nao existe!'], 404);

        $cidade->setAll($data);
        $cidade->setUf($uf);

        $cidade = $this->repository->persist($cidade); 
        
        return new CidadeResource($cidade);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cidade = $this->repository->find($id);   
        
        if (!$cidade)
            return response()->json(['message' => 'Cidade não existe!'], 404);

        $this->repository->remove($cidade); 
        
        return response()->json(['message' => 'Sucess!'], 200);
    }

}
