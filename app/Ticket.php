<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $table = 'tbltickets';

    public $timestamps = false;

    protected $dates = [
        'date',
        'lastreply',
        'replyingtime',
    ];
}
