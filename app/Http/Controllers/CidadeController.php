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
     * @OA\Get(
     *      path="/api/cidade",
     *      operationId="getCidade",
     *      tags={"Cidade"},
     *      summary="Lista de Cidades",
     *      description="Retorna uma lista de cidades",
     *      @OA\Response(response=200, description="successful operation", @OA\JsonContent),
     *      @OA\Response(response=400, description="Bad request"),
     *      security={{"bearerAuth": {}}}
     *     )
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
     * @OA\Post(
     *     path="/api/cidade",
     *     tags={"Cidade"},
     *     summary="Nova Cidade",
     *     operationId="postCidade",
     *     @OA\Response(response=200, description="Invalid input", @OA\JsonContent),
     *     @OA\Response(response=405, description="Invalid input"),
     *     @OA\Response(response=422, description="Invalid input"),
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         description="Create user object",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Cidade")
     *     )
     * )
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        $data = $request->all(); 

        $uf = $this->repositoryUf->find($data['uf']['id']);
        if (!$uf)
            return response()->json(['message' => 'UF nao existe!'], 404);  
            
        unset($data['uf']);    

        var_dump($data); die;

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
     * @OA\Get(
     *      path="/api/cidade/{id}",
     *      operationId="getCidadeById",
     *      tags={"Cidade"},
     *      summary="Pega as informações da Cidade",
     *      description="Retorna os dados da cidade",
     *      @OA\Parameter(
     *          name="id",
     *          description="Código",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(response=200, description="successful operation", @OA\JsonContent),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     *      security={{"bearerAuth": {}}},
     * )     
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
     * @OA\Put(
     *     path="/api/cidade/{id}",
     *     tags={"Cidade"},
     *     summary="Atualiza uma cidade",
     *     operationId="putCidade",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of uf that needs to be updated",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(response=200, description="Invalid input", @OA\JsonContent), 
     *     @OA\Response(response=405, description="Invalid input"),
     *     @OA\Response(response=422, description="Invalid input"),
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         description="Create user object",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Cidade")
     *     )
     * )
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
     * @OA\Delete(
     *      path="/api/cidade/{id}",
     *      operationId="delCidade",
     *      tags={"Cidade"},
     *      summary="Exclui uma Cidade",
     *      description="Excluir a cidade",
     *      @OA\Parameter(
     *          name="id",
     *          description="Código",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(response=200, description="successful operation", @OA\JsonContent),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     *      security={{"bearerAuth": {}}},
     * )
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
