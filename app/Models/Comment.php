<?php

namespace App\Models;

use App\Scopes\LatestScope;
use Illuminate\Database\Eloquent\Builder;
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

    public function scopeLatestComment(Builder $query)
    {
        return $query->orderBy(static::CREATED_AT, 'desc');
    }

    public static function boot()
    {
        parent::boot();

        // global query scopes
        // static::addGlobalScope(new LatestScope);
    }
}
