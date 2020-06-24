<?php
$title = 'Nilai Trend';
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
                                            <th>No</th>
                                            <th class="text-center">Tanggal</th>
                                            <th class="text-center">Jumlah titik (Y)</th>
                                            <th class="text-center">X</th>
                                            <th class="text-center">XY</th>
                                            <th class="text-center">X2</th>
                                            <th class="text-center">Y2</th>
                                            <th class="text-center">log Y</th>
                                            <th class="text-center">X log Y</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $logy = 0; $xlogy = 0; $x2 = 0 ?>
                                        @foreach ($data as $row)
                                            <tr>
                                                <td>{{$loop->iteration}}</td>
                                                <td>{{$row->waktu->format('d F Y')}}</td>
                                                <td class="text-center">{{$y = $row->jumlah}}</td>
                                                <td class="text-center">{{$x = $loop->index - floor($loop->count/2)}}</td>
                                                <td class="text-center">{{$y != 0 ? $x * $y : 0}}</td>
                                                <td class="text-center">{{pow($x, 2)}}</td>
                                                <td class="text-center">{{pow($y, 2)}}</td>
                                                <td class="text-center">{{!is_infinite(log10($y)) ? log10($y) : 0}}</td>
                                                <td class="text-center">{{!is_infinite(log10($y)) ? $x * log10($y) : 0}}</td>
                                            </tr>
                                            <?php
                                                $x2 += pow($x, 2);
                                                !is_infinite(log10($y)) ? $logy += log10($y) : $logy += 0;
                                                !is_infinite(log10($y)) ? $xlogy += $x * log10($y) : $xlogy += 0;
                                            ?>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Modal -->
                @if ($data->count() > 0)
                    <div class="modal fade" id="modal-hasil" tabindex="-1" role="dialog" aria-labelledby="modal-hasil-label" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modal-hasil-label">Nilai Trend</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <h5 class="text-center">Rumus Nilai Trend</h5>
                                    <h5 class="text-center"><strong><em>Y = a b<sup>x</sup></em></strong></h5>
                                    <div class="col-12">
                                        <div class="row mt-3">
                                            <div class="bg-purple col-6 pt-1">
                                                <h6 class="text-center"><strong><em>a</em> = {{$a = pow(10, $logy/$data->count())}}</strong></h6>
                                                <?php Cache::put('a', $a); ?>
                                            </div>
                                            <div class="bg-info col-6 pt-1">
                                                <h6 class="text-center"><strong><em>b</em> = {{$b = pow(10, $xlogy/$x2)}}</strong></h6>
                                                <?php Cache::put('b', $b); ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="row mt-3">
                                            <div class="bg-success col-12 pt-1">
                                                <h6 class="text-center"><strong><em>Y</em> = ({{$a}}) ({{$b}}) <em><sup>x</sup></em></strong></h6>
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

    </script>
@endpush
