<?php

namespace App\Http\Resources;

use App\Models\Art;
use Illuminate\Http\Resources\Json\JsonResource;
use Auth;
use Carbon\Carbon;

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

        $user = Auth::user();

        $hasLiked = $user->hasLiked(Art::find($this->id));

        $hasFavourited =
            $user->hasFavorited(Art::find($this->id));

        $latestLikers = Art::find($this->id)->latest_likers;


        if ($this->is3d == 1) {
            $is3d = true;
        } else {
            $is3d = false;
        }

        // if (is_null($latestLikers)) {
        //     # code...
        //     $latestLikers = [];
        // }

        // dd($latestLikers);
        // return parent::toArray($request);
        return [
            'id' => $this->id,
            'title' => $this->title,
            'is3d' => $is3d,
            'description' => $this->description,
            'location' => $this->location,
            'like_count' => $this->like_count,
            'image' => $this->image,
            'category' => new CategoryResource($this->category),
            'subcategory' => new SubCategoryResource($this->subcategory),
            'artist' => new UserResource($this->artist),
            'hasLiked' => $hasLiked,
            'hasFavourited' => $hasFavourited,
            'latestLikers' => UserResource::collection($latestLikers),
            'post_date' => Carbon::parse($this->created_at)->format('F d Y')
            // 'id' => $this->id,
        ];
    }
}
