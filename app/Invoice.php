<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $table = 'tblinvoices';

    public $timestamps = false;

    protected $dates = [
        'date',
        'duedate',
    ];

    public function client()
    {
        return $this->belongsTo('App\Client', 'userid');
    }


    public function item()
    {
        return $this->hasMany('App\InvoiceItem', 'invoiceid');
    }
}
