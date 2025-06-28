<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;
    protected $guarded = ['id,name,email,address,latitude,longitude,radius_km,time_in,time_out,created_at,updated_at'];

    public function attendance()
    {
        return $this->hasMany(Attendance::class);
    }
    public function user()
    {
        return $this->hasMany(User::class);
    }

}