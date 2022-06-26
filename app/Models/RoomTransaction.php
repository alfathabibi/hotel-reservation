<?php

namespace App\Models;
use App\Models\Room;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomTransaction extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function room(){
        return $this->belongsTo(Room::class);
    }
}
