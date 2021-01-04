<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kecamatan extends Model
{
    protected $table = 'kecamatan';
    protected $guarded = ['id'];

    protected $appends = [
        'jumlah_dataset'
    ];

    public function getJumlahDatasetAttribute()
    {
        return $this->dataset()->count();
    }

    public function dataset()
    {
        return $this->hasMany('App\Dataset');
    }
}
