<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Binarylog extends Model
{
    use HasFactory;
    protected $table = 'binarylogs';
    protected $guarded = [];
    public $timestamps = true;
}
