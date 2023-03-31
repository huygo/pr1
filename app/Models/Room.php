<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;
    const STATUS_ACTIVE = 1;
    const STATUS_DELETE = 0;
    protected $fillable = [
        'name',
        'number',
        'status',
    ];
    protected $table = 'room';
}
