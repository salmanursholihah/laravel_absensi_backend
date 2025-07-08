<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    protected $appends = ['is_late'];

public function getIsLateAttribute()
{
    if (!$this->check_in_time) return false;

    return strtotime($this->check_in_time) > strtotime('08:00:00');
}


}