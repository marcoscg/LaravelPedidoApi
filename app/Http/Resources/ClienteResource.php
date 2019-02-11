<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ClienteResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->getId(),
            'razao_socail' => $this->getRazaoSocial(),
            'cidade' => new CidadeResource($this->getCidade()),
            'segmento' => new SegmentoResource($this->getSegmento()),
            'contatos' => $this->getContatos($this->getContato()),
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
