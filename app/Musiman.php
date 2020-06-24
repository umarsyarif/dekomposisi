<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Musiman extends Model
{
    protected $table = 'musiman';
    protected $guarded = ['id'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['waktu'];
}
