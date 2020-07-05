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
                        <table id="example1" class="table table-bordered table-striped">
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
                                    <?php $xt; $aditif = ($a + pow($b, $xt)) + $row->musiman; $multiplikatif = ($a + pow($b, $xt)) * $row->musiman ?>
                                    <td>{{$xt++}}</td>
                                    <td class="text-center">{{$row->waktu->format('d F Y')}}</td>
                                    <td class="text-center">{{$jumlah = $row->jumlah}}</td>
                                    <td class="text-center">{{round($aditif)}}</td>
                                    <td class="text-center">{{$jumlah != 0 ? ($jumlah - $aditif) / $row->jumlah : 0}}</td>
                                    <td class="text-center">{{round($multiplikatif)}}</td>
                                    <td class="text-center">{{$jumlah != 0 ? ($jumlah - $multiplikatif) / $row->jumlah : 0}}</td>
                                </tr>
                                <?php
                                    $jumlahAditif += $aditif;
                                    $jumlahMultiplikatif += $multiplikatif;
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
                                    <h6 class="text-center"><strong>Aditif <br> <em>{{round($jumlahAditif / $uji->count(), 2)}} %</em></strong></h6>
                                </div>
                                <div class="bg-info col-6 pt-1">
                                    <h6 class="text-center"><strong>Multiplikatif <br> <em>{{round($jumlahMultiplikatif / $uji->count(), 2)}} %</em></strong></h6>
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

        $(function () {
          $("#example1").DataTable({
            "autoWidth": true
          });
        });

        $("#datepicker").daterangepicker();

    </script>
@endpush
