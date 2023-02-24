<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GeneralResponse extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return ([
            'code'  => 200,
            'status' => true,
            'data' => isset($this['data']) ? $this['data'] : array(),
            'message' => isset($this['message']) ? $this['message'] : ''
        ]);
    }
}
