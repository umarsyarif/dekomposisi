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
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="card-body col-6">
                                <p class="text-center">Rumus Nilai Indeks Musiman :</p>
                                <div class="col-12">
                                    <div class="row mt-3">
                                        <div class="border col-12 pt-1">
                                            <h6 class="text-center"><strong><em>Nilai Penyesuaian</em> = {{$penyesuaian}} </strong></h6>
                                        </div>
                                        <div class="border col-12 pt-1">
                                            <h6 class="text-center"><strong><em>Jumlah Indeks Musiman</em> = {{$jumlahIndeks}} </strong></h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body col-6">
                                <h5>Nilai Indeks Musiman</h5>
                                <p class="text-muted">Untuk mencari nilai indeks musiman pada proses Dekomposisi, digunakan salah satu metode indeks musiman yaitu metode rasio terhadap rata-rata bergerak.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="text-center">Nilai Indeks Musiman</h4>
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
                                                <th class="text-center">{{$row->year}}</th>
                                            @endforeach
                                        </tr>
                                    </thead>
                                    <tbody>
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
                                                <td class="text-center">{{round($row->medial * $penyesuaian, 2)}}</td>
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
    <script>

        $(function () {
          $("#example1").DataTable({
            "autoWidth": true
          });
        });

    </script>
@endpush
