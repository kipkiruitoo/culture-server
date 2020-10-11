<?php

namespace App\Http\Resources;

use App\Models\Art;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\URL;
use App\Models\User;

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

        // $user = User::find($this->id);
        $postcount = Art::where('user_id', $this->id)->count();
        if (is_null($this->profile_photo_path)) {



            $profile_url = "https://ui-avatars.com/api/?name=" . urlencode($this->name) . "&color=7F9CF5&background=EBF4FF";
        } else {
            $profile_url =
                env('APP_URL') . '/storage/' . $this->profile_photo_path;
        }
        return [
            'id' => $this->id,
            'name' => $this->name,
            'bio' => $this->bio,
            'email' => $this->id,
            'avatar' => $this->avatar,
            'follower_count' => $this->follower_count,
            'following_count' => $this->following_count,
            'profile_photo_path:' => $this->profile_photo_path,
            'profile_photo_url' => $profile_url,
            'post_count' => $postcount
        ];
    }
}
