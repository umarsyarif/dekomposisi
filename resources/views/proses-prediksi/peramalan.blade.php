<?php
$title = 'Peramalan';
?>
@extends('layouts.main')

@section('title', $title)

@section('content')
<div id="app">
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <!-- Page Title -->
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">{{$title}}</h1>
                    </div>
                    @include('partials.breadcrumb', ['breadcrumbs' => ['search.index' => 'Pencarian']])
                </div>
            </div>
        </div>
        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="card">
                    <form action="{{route('prediksi.hasil')}}" method="post">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="datepicker">Tanggal</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="datepicker" name="tanggal"  value="{{$tanggal}}" required>
                                    <div class="input-group-append">
                                        <span class="input-group-text">
                                            <i class="fas fa-calendar"></i>
                                        </span>
                                    </div>
                                    <button type="submit" class="btn btn-primary ml-2">Check</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card card-primary card-outline card-tabs">
                    <div class="card-header p-0 border-bottom-0">
                        <ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="custom-tabs-three-trend-tab" data-toggle="pill" href="#custom-tabs-three-trend" role="tab" aria-controls="custom-tabs-three-trend" aria-selected="true">Nilai Trend</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="custom-tabs-three-musiman-tab" data-toggle="pill" href="#custom-tabs-three-musiman" role="tab" aria-controls="custom-tabs-three-musiman" aria-selected="false">Nilai Indeks Musiman</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="custom-tabs-three-hasil-tab" data-toggle="pill" href="#custom-tabs-three-hasil" role="tab" aria-controls="custom-tabs-three-hasil" aria-selected="false">Hasil Prediksi</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content" id="custom-tabs-three-tabContent">
                            <div class="tab-pane fade show active" id="custom-tabs-three-trend" role="tabpanel" aria-labelledby="custom-tabs-three-trend-tab">
                                <table id="trend" class="table datatable table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th class="text-center">Tanggal</th>
                                            <th class="text-center">Titik Api (Y)</th>
                                            <th class="text-center">X</th>
                                            <th class="text-center">XY</th>
                                            <th class="text-center">X2</th>
                                            <th class="text-center">Y2</th>
                                            <th class="text-center">log Y</th>
                                            <th class="text-center">X log Y</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $row)
                                        <tr>
                                            <td class="text-center">{{$loop->iteration}}</td>
                                            <td class="text-center">{{$row->waktu->format('d F Y')}}</td>
                                            <td class="text-center" id="y-{{$loop->iteration}}">{{$row->jumlah}}</td>
                                            <td class="text-center" id="x-{{$loop->iteration}}"></td>
                                            <td class="text-center" id="xy-{{$loop->iteration}}"></td>
                                            <td class="text-center" id="x2-{{$loop->iteration}}"></td>
                                            <td class="text-center" id="y2-{{$loop->iteration}}"></td>
                                            <td class="text-center" id="logy-{{$loop->iteration}}"></td>
                                            <td class="text-center" id="xlogy-{{$loop->iteration}}"></td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="tab-pane fade" id="custom-tabs-three-musiman" role="tabpanel" aria-labelledby="custom-tabs-three-musiman-tab">
                                <table id="musiman" class="table datatable table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th class="text-center" rowspan="2">No</th>
                                            <th class="text-center" rowspan="2">Tanggal / Bulan</th>
                                            <th class="text-center" colspan="{{$musiman['year']->count()}}">Jumlah titik api</th>
                                            <th class="text-center" rowspan="2">Rata-Rata Medial</th>
                                            <th class="text-center" rowspan="2">Indeks Musiman</th>
                                        </tr>
                                        <tr>
                                            @foreach ($musiman['year'] as $row)
                                                <th class="text-center">{{$row}}</th>
                                            @endforeach
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $jumlahIndeks = 0; ?>
                                        @foreach ($musiman['data'] as $row)
                                            <tr>
                                                <td>{{$loop->iteration}}</td>
                                                <td class="text-center">{{$row->day}} {{date('F', mktime(0, 0, 0, $row->month, 10))}}</td>
                                                @foreach ($row->ma as $item)
                                                    <?php $ma = $item ?? '-' ?>
                                                    <td class="text-center">{{$ma > 0 ? round($ma, 2) : $ma}}</td>
                                                @endforeach
                                                <?php
                                                ?>
                                                <td class="text-center">{{$medial = round($row->medial, 2)}}</td>
                                                <td class="text-center">{{$indeks = round($medial * $musiman['penyesuaian'], 2)}}</td>
                                                <?php $jumlahIndeks += $indeks ?>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="tab-pane fade" id="custom-tabs-three-hasil" role="tabpanel" aria-labelledby="custom-tabs-three-hasil-tab">
                                <table id="hasil" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th class="text-center" rowspan="2">No</th>
                                            <th class="text-center" rowspan="2">Tanggal / Bulan</th>
                                            <th class="text-center" rowspan="2">Xt</th>
                                            <th class="text-center" colspan="2">Peramalan Jumlah Titik Api</th>
                                        </tr>
                                        <tr>
                                            <td class="text-center">Dekomposisi Aditif</td>
                                            <td class="text-center">Dekomposisi Multiplikatif</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $jumlahAditif = 0; $jumlahMultiplikatif = 0; ?>
                                        @foreach ($uji as $row)
                                        <tr>
                                            <td class="text-center">{{$loop->iteration}}</td>
                                            <td class="text-center">{{$row->waktu->format('d F Y')}}</td>
                                            <td class="text-center" id="xt-{{$loop->iteration}}"></td>
                                            <td class="text-center" id="aditif-{{$loop->iteration}}"></td>
                                            <td class="text-center" id="multiplikatif-{{$loop->iteration}}"></td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script>

        $("#datepicker").daterangepicker({
            locale: {
                format: 'DD/MM/YYYY'
            }
        });

        const a = 0;
        const b = 0;
        $(document).ready(() => {
            $('.replace').remove();
            getTrend().then(result => {
                this.a = result.a;
                this.b = result.b;
                replace();
            });
        });

        const getTrend = async () => {
            const dataLatih = {!! json_encode($data->toArray()) !!};
            const split = _.size(dataLatih) / 2;
            let iteration = 1;
            let logy = 0, xlogy = 0, x2 = 0;
            $.each(dataLatih, (index, value) => {
                let temp, x, y = value.jumlah, a = 0, b = 0;
                let log10y = Math.log10(y);
                $('#x-'+iteration).html(x = getX(iteration, split));
                $('#xy-'+iteration).html(y != 0 ? x * y : 0);
                $('#x2-'+iteration).html(Math.pow(x, 2));
                $('#y2-'+iteration).html(Math.pow(y, 2));
                $('#logy-'+iteration).html(isFinite(log10y) ? a = log10y.toFixed(3) : a = 0);
                $('#xlogy-'+iteration).html(isFinite(log10y) ? b = (x * a).toFixed(3) : b = 0);
                x2 += Math.pow(x, 2);
                logy += parseFloat(a);
                xlogy += parseFloat(b);
                iteration++;
            });
            const a = Math.pow(10, logy / _.size(dataLatih)).toFixed(9);
            const b = Math.pow(10, xlogy / x2).toFixed(9);
            return {a, b};
        }

        const getX = (iteration, split) =>{
            const current = iteration - Math.round(split);
            if (split * 2 % 2 == 0){
                return  current * 2 - 1;
            }
            return current + 1;
        }

        const replace  = () => {
            const dataUji = {!! json_encode($uji->toArray()) !!};
            let xt = "{{ $xt }}";
            let iteration = 1;
            $.each(dataUji, (index, value) => {
                console.log('asd');
                const result = parseFloat(this.a) * Math.pow(parseFloat(this.b), parseFloat(xt));
                $('#xt-'+iteration).html(xt);
                $('#aditif-'+iteration).html(Math.round(result + parseFloat(value.musiman.toFixed(2))));
                $('#multiplikatif-'+iteration).html(Math.round(result * parseFloat(value.musiman.toFixed(2))));
                iteration++;
                xt++;
            })

            $('.datatable').DataTable({
                "autoWidth": true
            });
        }
    </script>
@endpush
