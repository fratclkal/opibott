<?php

namespace App\Console\Commands;

use App\Http\Controllers\Calc;
use Illuminate\Console\Command;
use Carbon\Carbon;

class MatchingBot extends Command
{

    protected $signature = 'quote:matching';


    protected $description = 'Her gün sonu gece hesaplar';


    public function __construct()
    {
        parent::__construct();
    }


    public function handle()
    {

        Calc::calcMatchingAllUsers();

    }
}
