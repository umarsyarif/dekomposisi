<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kecamatan extends Model
{
    protected $table = 'kecamatan';
    protected $guarded = ['id'];

    public function dataset()
    {
        return $this->hasMany('App\Dataset');
    }
}
