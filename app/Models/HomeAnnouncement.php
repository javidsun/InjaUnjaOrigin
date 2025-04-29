<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HomeAnnouncement extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'content',
        'status',
        'is_pinned',
        'is_pinned_full'
    ];
    protected $hidden = [
        'subtitle',
        'link',
        'description',
        'image',
    ];
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
