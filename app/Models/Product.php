<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $guarded = [];

    public $timestamps = false;

    public function category()
    {
        return $this->belongsTo(Category::class);   
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
