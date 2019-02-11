<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class SegmentosResource extends ResourceCollection
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
            'segmento' => $this->collection->transform(function($page){
                return [
                    'id' => $page->getId(),
                    'descricao' => $page->getDescricao(),
                ];
            }),
        ];
    }
}
