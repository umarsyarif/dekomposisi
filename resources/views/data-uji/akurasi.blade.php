<?php
$title = 'Persentase Kesalahan';
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
                    <form action="{{route('data-uji.akurasi')}}" method="post">
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
                <div class="card">
                    <div class="card-header">
                        <button class="btn btn-primary float-right" data-toggle="modal" data-target="#modal-hasil">
                            Cek MAPE
                        </button>
                    </div>
                    <div class="card-body">
                        <table id="example1" class="table datatable table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center" rowspan="2">No</th>
                                    <th class="text-center" rowspan="2">Tanggal / Bulan</th>
                                    <th class="text-center" rowspan="2">Data Aktual</th>
                                    <th class="text-center" colspan="2">Dekomposisi Aditif</th>
                                    <th class="text-center" colspan="2">Dekomposisi Multiplikatif</th>
                                </tr>
                                <tr>
                                    <td class="text-center">Jumlah Titik Api</td>
                                    <td class="text-center">Error</td>
                                    <td class="text-center">Jumlah Titik Api</td>
                                    <td class="text-center">Error</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $jumlahAditif = 0; $jumlahMultiplikatif = 0; ?>
                                @foreach ($uji as $row)
                                <tr>
                                    <?php
                                        $trend = ($a + round(pow($b, $xt), 2));
                                        $aditif = $trend + round($row->musiman, 2);
                                        $multiplikatif = $trend * round($row->musiman, 2) ?>
                                    <td>{{$loop->iteration}}</td>
                                    <td class="text-center">{{$row->waktu->format('d F Y')}}</td>
                                    <td class="text-center">{{$jumlah = $row->jumlah}}</td>
                                    <td class="text-center" id="aditif-{{$loop->iteration}}"></td>
                                    <td class="text-center" id="error-aditif-{{$loop->iteration}}"></td>
                                    <td class="text-center" id="multiplikatif-{{$loop->iteration}}"></td>
                                    <td class="text-center" id="error-multiplikatif-{{$loop->iteration}}"></td>
                                    {{-- <td class="text-center" id="error-aditif-{{$loop->iteration}}">{{$jumlah != 0 ? $errorAditif = round(($jumlah - $aditif) / $jumlah, 2) : $errorAditif = 0}}</td> --}}
                                    {{-- <td class="text-center">{{$multiplikatif = round($multiplikatif)}}</td> --}}
                                    {{-- <td class="text-center">{{$jumlah != 0 ? $errorMultiplikatif = round(($jumlah - $multiplikatif) / $jumlah   , 2) : $errorMultiplikatif = 0}}</td> --}}
                                </tr>
                                <?php
                                    // $xt++;
                                    // $jumlahAditif += $errorAditif;
                                    // $jumlahMultiplikatif += $errorMultiplikatif;
                                ?>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="modal-hasil" tabindex="-1" role="dialog" aria-labelledby="modal-hasil-label" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal-hasil-label">Peramalan Jumlah Titik Api</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <h5 class="text-center">Akurasi</h5>
                        <div class="col-12">
                            <div class="row mt-3">
                                <div class="bg-purple col-6 pt-1">
                                    <h6 class="text-center"><strong>Aditif <br> <em>{{round(abs(round($jumlahAditif, 2) * 100/ $uji->count()), 2)}} %</em></strong></h6>
                                </div>
                                <div class="bg-info col-6 pt-1">
                                    {{-- <h6 class="text-center"><strong>Aditif <br> <em>{{$jumlahMultiplikatif}} %</em></strong></h6> --}}
                                    <h6 class="text-center"><strong>Multiplikatif <br> <em>{{round(abs(round($jumlahMultiplikatif, 2) * 100/ $uji->count()), 2)}} %</em></strong></h6>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
                    </div>
                </div>
            </div>
        </div>
        {{-- end modal --}}
    </div>
</div>
@endsection
@push('scripts')
    <script>

        $("#datepicker").daterangepicker();

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
                const result = parseFloat(this.a) * Math.pow(parseFloat(this.b), parseFloat(xt));
                $('#xt-'+iteration).html(xt);
                $('#aditif-'+iteration).html(aditif = Math.round(result + parseFloat(value.musiman.toFixed(2))));
                $('#error-aditif-'+iteration).html((value.jumlah - aditif) / value.jumlah);
                $('#multiplikatif-'+iteration).html(multiplikatif = Math.round(result * parseFloat(value.musiman.toFixed(2))));
                $('#error-multiplikatif-'+iteration).html((value.jumlah - multiplikatif) / value.jumlah)
                iteration++;
                xt++;
            })

            $('.datatable').DataTable({
                "autoWidth": true
            });
        }

    </script>
@endpush
