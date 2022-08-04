<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayLog extends Model
{
    use HasFactory;
    protected $table = 'pay_logs';
    protected $guarded = [];
    public $timestamps = true;
}
