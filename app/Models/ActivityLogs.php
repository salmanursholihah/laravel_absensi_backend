<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityLogs extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'action', 'model_type', 'model_id', 'description'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}