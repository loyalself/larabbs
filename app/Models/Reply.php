<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reply extends Model
{
    protected $fillable = ['content'];

    /**
     * 一条回复对应一个话题,一对一
     * @return BelongsTo
     */
    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }
    /**
     * 一条回复对应一个用户,一对一
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
