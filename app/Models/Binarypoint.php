<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Binarypoint extends Model
{
    use HasFactory;
    protected $table = 'binarypoints';
    protected $guarded = [];
    public $timestamps = true;
}
