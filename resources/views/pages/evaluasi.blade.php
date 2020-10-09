<?php
$title = 'Evaluasi Kesalahan';
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
                    <div class="card-body">
                        <div class="row">
                            <div class="card-body col-6">
                                <p class="text-center">Persentase Kesalahan :</p>
                                <div class="col-12">
                                    <div class="row mt-3">
                                        <div class="border col-12 pt-1">
                                            <h6 class="text-center"><strong><em>Peramalan Aditif</em> = {{round($jumlah['aditif'] * 100 / $uji->count(), 2)}} </strong></h6>
                                        </div>
                                        <div class="border col-12 pt-1">
                                            <h6 class="text-center"><strong><em>Peramalan Multiplikatif</em> = {{round($jumlah['multiplikatif'] * 100 / $uji->count(), 2)}} </strong></h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body col-6">
                                <h5>Evalusi Kesalahan</h5>
                                <p class="text-muted"> Pada tahap ini akan dilakukan pemeriksaan apakah pola atau informasi yang ditemukan bertentangan dengan fakta atau hipotesis sebelumnya. Evaluasi data menggunakan perhitungan kesalahan peramalan (error) yaitu MAPE.                       MAPE=(∑(Aktual-Ramalan)/Aktual× 100%)/n.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    {{-- <div class="card-header">
                        <button class="btn btn-primary float-right" data-toggle="modal" data-target="#modal-hasil">
                            Cek MAPE
                        </button>
                    </div> --}}
                    <div class="card-body">
                        <h4 class="text-center">Evaluasi Kesalahan</h4>
                        <table id="example1" class="table datatable table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center" rowspan="2">No</th>
                                    <th class="text-center" rowspan="2">Tanggal / Bulan</th>
                                    <th class="text-center" rowspan="2">Data Aktual (A)</th>
                                    <th class="text-center" colspan="2">Dekomposisi Aditif</th>
                                    <th class="text-center" colspan="2">Dekomposisi Multiplikatif</th>
                                </tr>
                                <tr>
                                    <td class="text-center">Ramalan (Fa)</td>
                                    <td class="text-center">Error (A-Fa) / 2</td>
                                    <td class="text-center">Ramalan (Fm)</td>
                                    <td class="text-center">Error (A-Fm) / 2</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $jumlahAditif = 0; $jumlahMultiplikatif = 0; ?>
                                @foreach ($uji as $row)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td class="text-center">{{$row->waktu->format('d F Y')}}</td>
                                    <td class="text-center">{{$jumlah = $row->jumlah}}</td>
                                    <td class="text-center">{{$row->aditif}}</td>
                                    <td class="text-center">{{round($row->error_aditif, 2)}}</td>
                                    <td class="text-center">{{$row->multiplikatif}}</td>
                                    <td class="text-center">{{round($row->error_multiplikatif, 2)}}</td>
                                </tr>
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

        $(function () {
          $("#example1").DataTable({
            "autoWidth": true
          });
        });

        $("#datepicker").daterangepicker();

    </script>
@endpush
