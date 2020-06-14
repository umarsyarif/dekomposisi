<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Uji extends Model
{
    protected $table = 'uji';
    protected $guarded = ['id'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['waktu'];
}
