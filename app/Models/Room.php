<?php

namespace App\Models;

use App\Models\RoomPhotos;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Room extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function photos(){
        return $this->hasMany(RoomPhotos::class);
    }

    public function delete(){
        $this->photos()->delete();
        
        return parent::delete();
    }
}
