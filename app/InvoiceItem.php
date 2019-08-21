<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvoiceItem extends Model
{
    protected $table = 'tblinvoiceitems';

    public function client()
    {
        return $this->belongsTo('App\Invoice', 'invoiceid');
    }
}
