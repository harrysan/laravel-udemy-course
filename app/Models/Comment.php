<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use HasFactory;
    use SoftDeletes;

    // blog_post_id
    public function blogPost()
    {
        //return $this->belongsTo('App\Models\BlogPost','post_id','blog_post_id');
        return $this->belongsTo('App\Models\BlogPost');
    }
}
