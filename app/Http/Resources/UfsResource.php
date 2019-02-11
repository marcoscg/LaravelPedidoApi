<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class UfsResource extends ResourceCollection
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
            'uf' => $this->collection->transform(function($page){
                return [
                    'id' => $page->getId(),
                    'uf' => $page->getUf(),
                    'descricao' => $page->getDescricao(),
                ];
            }),
        ];
    }
}
