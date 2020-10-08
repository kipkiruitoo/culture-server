<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SingleArt extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'location' => $this->location,
            'image' => $this->image,
            'category' => new CategoryResource($this->category),
            'subcategory' => new SubCategoryResource($this->subcategory),
            'artist' => new UserResource($this->artist)
            // 'id' => $this->id,
        ];
    }
}
