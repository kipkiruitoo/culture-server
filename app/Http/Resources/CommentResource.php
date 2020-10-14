<?php

namespace App\Http\Resources;

use App\Models\Art;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class CommentResource extends JsonResource
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
            'comment' => $this->comment,
            'artist' => new UserResource(User::find($this->commented_id)),
            'art' => new SingleArt(Art::find($this->commentable_id)),
            'comment_date' => Carbon::parse($this->created_at)->format('F d Y')
        ];
    }
}
