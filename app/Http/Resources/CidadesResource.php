<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Http\Resources\UfResource;

class CidadesResource extends ResourceCollection
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
            'cidade' => $this->collection->transform(function($page){
                return [
                    'id' => $page->getId(),
                    'descricao' => $page->getDescricao(),
                    'uf' => new UfResource($page->getUf()),
                ];
            }),
        ];
    }
}
