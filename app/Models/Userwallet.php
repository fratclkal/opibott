<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Userwallet extends Model
{
    use HasFactory;
    protected $table = 'userwallets';
    protected $guarded = [];
    public $timestamps = true;
}
