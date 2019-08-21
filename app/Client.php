<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tblclients';

    protected $dates = [
        'datecreated',
    ];

    public function invoice()
    {
        return $this->hasMany('App\Invoice', 'userid');
    }

}
