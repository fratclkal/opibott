<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RankLog extends Model
{
    use HasFactory;
    protected $table = 'ranklogs';
    protected $guarded = [];
    public $timestamps = true;
}
