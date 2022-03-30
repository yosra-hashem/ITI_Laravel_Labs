<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Laravel\Sanctum\HasApiTokens;


class Post extends Model
{
    use HasFactory , Sluggable , HasApiTokens;
   
    
    protected $table="posts";

    protected $fillable = ['title','desc','user_id' ,'slug','created_at' , 'updated_at'];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }
    
    public $timestamps = true;

    public function user(){
        return $this->belongsTo(User::class);
    }
    
}

