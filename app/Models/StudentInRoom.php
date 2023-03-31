<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentInRoom extends Model
{
    use HasFactory;
    const STATUS_ACTIVE = 1;
    const STATUS_DELETE = 0;
    protected $fillable = [
        'student_id',
        'room_id',
    ];
    public $timestamps = false;
    protected $table = 'student_in_room';
}
