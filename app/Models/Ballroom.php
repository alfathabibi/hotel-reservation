<?php

namespace App\Models;

use App\Models\BallroomPhotos;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ballroom extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function photos(){
        return $this->hasMany(BallroomPhotos::class);
    }

    public function delete(){
        $this->photos()->delete();
        
        return parent::delete();
    }
}
