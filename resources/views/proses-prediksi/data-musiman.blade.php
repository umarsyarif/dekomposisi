<?php
$title = 'Nilai Indeks Musiman';
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
                <div class="row">
                    <div class="col-lg-12">
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
                                            <th class="text-center" colspan="{{$year->count()}}">Jumlah titik api</th>
                                            <th class="text-center" rowspan="2">Rata-Rata Medial</th>
                                            <th class="text-center" rowspan="2">Indeks Musiman</th>
                                        </tr>
                                        <tr>
                                            @foreach ($year as $row)
                                                <th class="text-center">{{$row}}</th>
                                            @endforeach
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $jumlahIndeks = 0; ?>
                                        @foreach ($data as $row)
                                            <tr>
                                                <td>{{$loop->iteration}}</td>
                                                <td class="text-center">{{$row->day}} {{date('F', mktime(0, 0, 0, $row->month, 10))}}</td>
                                                @foreach ($row->ma as $item)
                                                    <?php $ma = $item ?? '-' ?>
                                                    <td class="text-center">{{$ma > 0 ? round($ma, 2) : $ma}}</td>
                                                @endforeach
                                                <?php
                                                ?>
                                                <td class="text-center">{{$row->medial}}</td>
                                                <td class="text-center">{{$indeks = $row->medial * $penyesuaian}}</td>
                                                <?php $jumlahIndeks += $indeks ?>
                                            </tr>
                                            {{-- <?php die() ?> --}}
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
                                <h5 class="modal-title" id="modal-hasil-label">Nilai Indeks Musiman</h5>
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
                                            <h6 class="text-center"><strong><em>Nilai penyesuaian</em>  {{$penyesuaian}}</strong></h6>
                                        </div>
                                        <div class="bg-info col-6 pt-1">
                                            <h6 class="text-center"><strong><em>Jumlah Indeks Musiman</em> <br> {{$jumlahIndeks}}</strong></h6>
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

    </script>
@endpush
