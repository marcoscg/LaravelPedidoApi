<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ClientesResource extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'cliente' => $this->collection->transform(function($page){
                return [
                    'id' => $page->getId(),
                    'razao_socail' => $page->getRazaoSocial(),
                    'cidade' => new CidadeResource($page->getCidade()),
                    'segmento' => new SegmentoResource($page->getSegmento()),
                    'contatos' => $this->getContatos($page->getContato()),
                ];
            }),
        ];
    }

    /**
     * 
     */
	public function getContatos($contatos)
	{
        $dados = [];
        foreach($contatos as $contato) {
            $dados[] = new ContatoResource($contato);
        }        

        return $dados;
    }    
}
