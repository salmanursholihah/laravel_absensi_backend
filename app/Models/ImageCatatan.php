<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImageCatatan extends Model
{
   protected $fillable =['id','catatan_id','image_path','created_at','updated_at'];
   public function catatan()
   {
    return $this->belongsTo(Catatan::class);
   }

}