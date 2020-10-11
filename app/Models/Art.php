<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Overtrue\LaravelFavorite\Traits\Favoriteable;
use Overtrue\LaravelLike\Traits\Likeable;
use Actuallymab\LaravelComment\Contracts\Commentable;
use Actuallymab\LaravelComment\HasComments;

class Art extends Model implements Commentable
{
    use HasFactory;
    use Favoriteable;
    use Likeable;
    use HasComments;

    protected $fillable = ['title', 'description', 'location', 'image', 'user_id', 'category_id', 'sub_category_id'];


    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function subcategory()
    {
        return $this->belongsTo(SubCategory::class, 'sub_category_id');
    }


    public function artist()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getLatestLikersAttribute()
    {
        return $this->likers;
    }


    public function getLikeCountAttribute()
    {

        return $this->likers()->count();
    }
}
