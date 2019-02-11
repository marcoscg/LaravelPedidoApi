<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ContatoResource extends JsonResource
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
            'nome' => $this->getNome(),
            'cargo' => $this->getCargo(),
            'fones' => $this->getFones(($this->getFone())),
            'emails' => $this->getEmails($this->getEmail()),
        ];
    }

    /**
     * 
     */
	public function getFones($fones)
	{
        $dados = [];
        foreach($fones as $fone) {
            $dados[] = new ContatoFoneResource($fone);
        }        

        return $dados;
    }    
    
    /**
     * 
     */
	public function getEmails($emails)
	{
        $dados = [];
        foreach($emails as $email) {
            $dados[] = new ContatoEmailResource($email);
        }        

        return $dados;
    }     
}
