<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Catatan extends Model
{
    use HasFactory;
    protected $fillable = ['id','title','description','image','created_at','updated_at','user_id','name'];

    public function user(){
        return  $this->belongsTo(User::class);
    }

    public function images()
    {
        return $this->hasMany(ImageCatatan::class);
    }

 public function activityLogs()
{
    return $this->hasMany(ActivityLogs::class, 'model_id')
        ->where('model_type', self::class);
}

}