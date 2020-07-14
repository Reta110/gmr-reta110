<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    protected $fillable = ['title', 'description', 'priority', 'user_id', 'processor_id'];

    public function status()
    {
        return $this->belongsTo(Status::class);
    }
}
