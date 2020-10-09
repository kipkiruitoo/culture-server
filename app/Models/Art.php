<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Overtrue\LaravelLike\Traits\Likeable;

class Art extends Model
{
    use HasFactory;

    use Likeable;

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


    public function getLikeCountAttribute()
    {

        return $this->likers()->count();
    }
}
