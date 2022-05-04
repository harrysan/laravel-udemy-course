<?php

namespace App\Models;

use App\Scopes\DeletedAdminScope;
use App\Traits\Taggable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;

class BlogPost extends Model
{
    protected $fillable = ['title','content', 'user_id'];

    use SoftDeletes, Taggable;
    use HasFactory;

    public function comments() 
    {
        return $this->morphMany('App\Models\Comment', 'commentable')->latestcomment();
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    // public function tags()
    // {
    //     return $this->morphToMany('App\Models\Tag', 'taggable')->withTimestamps();
    // }

    public function image()
    {
        return $this->morphOne('App\Models\Image', 'imageable');
    }

    public function scopeLatest(Builder $query)
    {
        return $query->orderBy(static::CREATED_AT, 'desc');
    }

    public function scopeMostCommented(Builder $query)
    {
        // produce comments_count
        return $query->withCount('comments')->orderBy('comments_count', 'desc');
    }

    public function scopeLatestWithRelations(Builder $query)
    {
        return $query->latest()
                    ->withCount('comments')
                    ->with('user')
                    ->with('tags');
    }

    public static function boot()
    {
        // global query scopes
        static::addGlobalScope(new DeletedAdminScope);

        parent::boot();

        // move to observe
        // static::deleting(function (BlogPost $blogPost) {
        //     $blogPost->comments()->delete();
        //     // $blogPost->image()->delete();
        //     Cache::tags(['blog-post'])->forget("blog-post-{$blogPost->id}");
        // });

        // static::updating(function (BlogPost $blogPost) {
        //     Cache::tags(['blog-post'])->forget("blog-post-{$blogPost->id}");
        // });

        // static::restoring(function (BlogPost $blogPost) {
        //     $blogPost->comments()->restore();
        // });
    }
}
