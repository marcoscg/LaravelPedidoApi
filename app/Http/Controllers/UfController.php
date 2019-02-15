<?php

namespace App\Http\Controllers;

use Doctrine\ORM\EntityManagerInterface;

use App\Entities\Uf;
use App\Repositories\UfRepository;
use App\Http\Resources\UfResource;
use App\Http\Resources\UfsResource;
use App\Http\Requests\UfRequest As Request;

class UfController extends Controller
{

    private $repository;

    public function __construct(EntityManagerInterface $em)
    {
        //$this->middleware('auth:api');        
        $this->repository = new UfRepository($em);    
    }

    /**
     * Display a listing of the resource.
     * 
     * @OA\Get(
     *      path="/api/uf",
     *      operationId="getUf",
     *      tags={"UF"},
     *      summary="Get list of ufs",
     *      description="Returns list of ufs",
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
        
        $uf = $this->repository->all($field, $cond);

        return new UfsResource($uf);
    }

    /**
     * Store a newly created resource in storage.
     * 
     * @OA\Post(
     *     path="/api/uf",
     *     tags={"UF"},
     *     summary="Post a pet in the store with form data",
     *     operationId="postUf",
     *     @OA\Response(response=200, description="Invalid input", @OA\JsonContent),
     *     @OA\Response(response=405, description="Invalid input"),
     *     @OA\Response(response=422, description="Invalid input"),
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         description="Create user object",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Uf")
     *     )
     * )
     *      
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        $data = $request->all(); 

        $uf = new Uf();
        $uf->setAll($data);

        $uf = $this->repository->persist($uf);

        $uf = new UfResource($uf);

        return response()->json($uf, 201);
    }

    /**
     * Display the specified resource.
     * 
     * @OA\Get(
     *      path="/api/uf/{id}",
     *      operationId="getUfById",
     *      tags={"UF"},
     *      summary="Get uf information",
     *      description="Returns uf data",
     *      @OA\Parameter(
     *          name="id",
     *          description="Código id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(response=200, description="successful operation"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     *      security={{"bearerAuth": {}}},
     * )
     *
     * 
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $uf = $this->repository->find($id);   
        
        if (!$uf)
            return response()->json(['message' => 'Uf não existe!'], 404);

        return new UfResource($uf);
    }

    /**
     * Update the specified resource in storage.
     * 
     * @OA\Put(
     *     path="/api/uf/{id}",
     *     tags={"UF"},
     *     summary="Updates a pet in the store with form data",
     *     operationId="putUf",
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
     *         @OA\JsonContent(ref="#/components/schemas/Uf")
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
        $uf = $this->repository->find($id); 
        if (!$uf)
            return response()->json(['message' => 'Uf não existe!'], 404);
        $uf->setAll($data);

        $uf = $this->repository->persist($uf); 
        
        return new UfResource($uf);
    }

    /**
     * Remove the specified resource from storage.
     * 
     * @OA\Delete(
     *      path="/api/uf/{id}",
     *      operationId="delUf",
     *      tags={"UF"},
     *      summary="Get uf information",
     *      description="Returns uf data",
     *      @OA\Parameter(
     *          name="id",
     *          description="Código id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(response=200, description="successful operation"),
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
        $uf = $this->repository->find($id);   
        
        if (!$uf)
            return response()->json(['message' => 'Uf não existe!'], 404);

        $this->repository->remove($uf); 
        
        return response()->json(['message' => 'Sucess!'], 200);
    }

}
