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
                    <div class="card-header">
                        <button class="btn btn-primary float-right" data-toggle="modal" data-target="#modal-hasil">
                            <i class="fas fa-file mr-1"></i> Hasil
                        </button>
                    </div>
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center" rowspan="2">No</th>
                                    <th class="text-center" rowspan="2">Tanggal / Bulan</th>
                                    <th class="text-center" rowspan="2">xt</th>
                                    <th class="text-center" rowspan="2">Data Aktual</th>
                                    <th class="text-center" colspan="2">Aditif</th>
                                    <th class="text-center" colspan="2">Multiplikatif</th>
                                </tr>
                                <tr>
                                    <td class="text-center">Ramalan</td>
                                    <td class="text-center">Akurasi</td>
                                    <td class="text-center">Ramalan</td>
                                    <td class="text-center">Akurasi</td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($uji as $row)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td class="text-center">{{$row->waktu->format('d F Y')}}</td>
                                    <td class="text-center">{{++$xt}}</td>
                                    <td class="text-center">{{$row->jumlah}}</td>
                                    <td class="text-center">{{$aditif = ($a + pow($b, $xt)) + $row->musiman}}</td>
                                    <td class="text-center">{{($xt - $aditif) / $xt}}</td>
                                    <td class="text-center">{{$multiplikatif = ($a + pow($b, $xt)) * $row->musiman}}</td>
                                    <td class="text-center">{{($xt - $multiplikatif) / $xt}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="start-modal" tabindex="-1" role="dialog" aria-labelledby="start-modal-label" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="start-modal-label">Peramalan Jumlah Titik Api</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <h5 class="text-center">Rumus Nilai Indeks Musiman</h5>
                        <h6 class="text-center"><strong><em>Y = a b<sup>x</sup></em></strong></h6>
                        <div class="col-12">
                            <div class="row mt-3">
                                <div class="bg-purple col-6 pt-1">
                                    {{-- <h6 class="text-center"><strong><em>a</em> = {{$a = pow(10, $logy/$data->count())}}</strong></h6> --}}
                                </div>
                                <div class="bg-info col-6 pt-1">
                                    {{-- <h6 class="text-center"><strong><em>b</em> = {{$b = pow(10, $xlogy/$x2)}}</strong></h6> --}}
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="row mt-3">
                                <div class="bg-success col-12 pt-1">
                                    {{-- <h6 class="text-center"><strong><em>Y</em> = ({{$a}}) ({{$b}}) <em><sup>x</sup></em></strong></h6> --}}
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

    </script>
@endpush
