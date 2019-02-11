<?php

namespace App\Http\Controllers;

use Doctrine\ORM\EntityManagerInterface;

use App\Entities\Uf;
use App\Repositories\UfRepository;
use App\Http\Resources\UfResource;
use App\Http\Resources\UfsResource;
use App\Http\Requests\UfRequest As Request;

/**
 * @SWG\Get(
 *   path="/uf",
 *   summary="Lista UFs",
 *   @SWG\Response(response=200, description="successful operation"),
 *   @SWG\Response(response=406, description="not acceptable"),
 *   @SWG\Response(response=500, description="internal server error")
 * )
 * 
 * @SWG\Get(
 *   path="/uf/{customerId}",
 *   summary="Lista UFs",
 *   operationId="getUf",
 *   @SWG\Parameter(
 *     name="customerId",
 *     in="path",
 *     description="Código da UF.",
 *     required=true,
 *     type="integer"
 *   ),
 *   @SWG\Response(response=200, description="successful operation"),
 *   @SWG\Response(response=406, description="not acceptable"),
 *   @SWG\Response(response=500, description="internal server error")
 * )
 *
 */

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
