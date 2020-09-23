<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PhotoResource extends JsonResource
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
            "url" => $this->url,
            "caption" => $this->caption,
            //"owner_id" => $this->owner_id, 
            "owner_id" => new OwnerResource($this->owner_id),
        ];
        //return parent::toArray($request);
        return parent::toArray($request);
    }
}
