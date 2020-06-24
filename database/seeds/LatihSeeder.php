<?php

use App\Latih;
use Illuminate\Database\Seeder;

class LatihSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $period = new DatePeriod(
            new DateTime('2014-01-01'),
            new DateInterval('P1D'),
            new DateTime('2020-01-01')
        );
        foreach ($period as $key => $value) {
            Latih::updateOrCreate(['waktu' => $value->format('Y-m-d')]);
        }
    }
}
