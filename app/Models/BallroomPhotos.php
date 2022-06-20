<?php

namespace App\Models;

use App\Models\Ballroom;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BallroomPhotos extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function ballroom(){
        return $this->belongsTo(Ballroom::class);
    }
}
