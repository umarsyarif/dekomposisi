<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Latih extends Model
{
    protected $table = 'latih';
    protected $guarded = ['id'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['waktu'];
}
