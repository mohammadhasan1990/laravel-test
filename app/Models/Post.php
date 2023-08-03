<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $casts = ['is_published' => 'bool'];

    protected static function boot()
    {
        parent::boot();

        self::creating(function ($site) {
            $site->owner_id = auth()->id();
        });
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function site()
    {
        return $this->belongsTo(Site::class, 'site_id');
    }

    public function senedPosts()
    {
        return $this->hasMany(PostSend::class, 'post_id');
    }
}
