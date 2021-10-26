<?php

namespace App\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class ErrorResource extends JsonResource
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
            'code_message' => $this->getCodeMessage(),
            'field' => $this->getField(),
            'message' => $this->getMessage(),
        ];
    }
}
