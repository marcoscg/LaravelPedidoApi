<?php


namespace App\Http\Controllers;

use Doctrine\ORM\EntityManagerInterface;

use App\Entities\Segmento;
use App\Repositories\SegmentoRepository;
use App\Http\Resources\SegmentoResource;
use App\Http\Resources\SegmentosResource;
use App\Http\Requests\SegmentoRequest As Request;

class SegmentoController extends Controller
{
    private $repository;

    public function __construct(EntityManagerInterface $em)
    {
        //$this->middleware('auth:api');        
        $this->repository = new SegmentoRepository($em);    
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
        
        $segmento = $this->repository->all($field, $cond);

        return new SegmentosResource($segmento);
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

        $segmento = new Segmento();
        $segmento->setAll($data);

        $segmento = $this->repository->persist($segmento);

        $segmento = new SegmentoResource($segmento);

        return response()->json($segmento, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $segmento = $this->repository->find($id);   
        
        if (!$segmento)
            return response()->json(['message' => 'Segmento não existe!'], 404);

        return new SegmentoResource($segmento);
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
        $segmento = $this->repository->find($id); 
        if (!$segmento)
            return response()->json(['message' => 'Segmento não existe!'], 404);
        $segmento->setAll($data);

        $segmento = $this->repository->persist($segmento); 
        
        return new SegmentoResource($segmento);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $segmento = $this->repository->find($id);   
        
        if (!$segmento)
            return response()->json(['message' => 'Segmento não existe!'], 404);

        $this->repository->remove($segmento); 
        
        return response()->json(['message' => 'Sucess!'], 200);
    }

}
