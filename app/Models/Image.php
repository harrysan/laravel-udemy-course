<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Image extends Model
{
    use HasFactory;
    protected $fillable = ['path', 'blog_post_id'];

    public function blogPost()
    {
        return $this->belongsTo('App\Models\BlogPost');
    }

    public function url($post)
    {
        // Storage::url($this->path);
        // dd($post);
        return "http://127.0.0.1:8000/storage/$post";
        // asset($this->path);
    }
}
