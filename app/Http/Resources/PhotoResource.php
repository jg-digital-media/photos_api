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
            "owner" => new OwnerResource($this->owner),
            "alt" => "Photo: from the photo resource"
        ];
        //return parent::toArray($request);
    }
}
