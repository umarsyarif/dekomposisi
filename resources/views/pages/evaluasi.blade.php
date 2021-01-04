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
                @if ($kecamatan)
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="card-body col-6">
                                <p class="text-center">Persentase Kesalahan :</p>
                                <div class="col-12">
                                    <div class="row mt-3">
                                        <div class="border col-12 pt-1">
                                            <h6 class="text-center"><strong><em>Peramalan Aditif</em> = {{number_format((float)$jumlah['aditif'] / $uji->count(), 2, '.', '')}} </strong></h6>
                                        </div>
                                        <div class="border col-12 pt-1">
                                            <h6 class="text-center"><strong><em>Peramalan Multiplikatif</em> = {{number_format((float)$jumlah['multiplikatif'] / $uji->count(), 2, '.', '')}} </strong></h6>
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
                    <div class="card-body">
                        <h4 class="text-center">Evaluasi Kesalahan</h4>
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
                                    <td class="text-center">Ramalan</td>
                                    <td class="text-center">Absulute Percentage Error</td>
                                    <td class="text-center">Ramalan</td>
                                    <td class="text-center">Absulute Percentage Error</td>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- <?php $jumlahAditif = 0; $jumlahMultiplikatif = 0; ?> --}}
                                @foreach ($uji as $row)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td class="text-center">{{$row->waktu->format('d F Y')}}</td>
                                    <td class="text-center">{{$jumlah = $row->jumlah}}</td>
                                    <td class="text-center">{{$row->aditif}}</td>
                                    <td class="text-center">{{number_format((float)abs($row->error_aditif) * 100, 2, '.', '')}}</td>
                                    <td class="text-center">{{$row->multiplikatif}}</td>
                                    <td class="text-center">{{number_format((float)abs($row->error_multiplikatif) * 100, 2, '.', '')}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @else
                <div class="card">
                    <div class="card-header">
                        Kecamatan
                    </div>
                    <div class="card-body">
                        <form action="{{route('dekomposisi.evaluasi')}}">
                            <div class="col-6 form-group row">
                                <label for="kecamatan" class="col-sm-3 col-form-label">Kecamatan</label>
                                <div class="btn-group col-sm-9">
                                    <select class="custom-select" name="kecamatan">
                                        <option value="" selected>Pilih Kecamatan</option>
                                        @foreach ($allKecamatan as $row)
                                        <option value="{{$row->id}}" {{$kecamatan == $row->id ? 'selected' : ''}}>{{$row->nama}}</option>
                                        @endforeach
                                    </select>
                                    <button class="btn btn-primary"><i class="fas fa-search"></i> </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                @endif
            </div>
        </div>
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
