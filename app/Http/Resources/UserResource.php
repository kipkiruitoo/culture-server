<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\URL;

class UserResource extends JsonResource
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
            'id' => $this->id,
            'name' => $this->name,
            'bio' => $this->bio,
            'email' => $this->id,
            'avatar' => $this->avatar,
            'follower_count' => $this->follower_count,
            'following_count' => $this->following_count,
            'profile_photo_path:' => $this->profile_photo_path,
            'profile_photo_url' => env('APP_URL') . '/storage/' . $this->profile_photo_path
        ];
    }
}
