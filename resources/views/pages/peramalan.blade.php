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
                    <div class="card-body">
                        <div class="row">
                            <div class="card-body col-6">
                                <form action="{{route('dekomposisi.peramalan')}}">
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="datepicker">Tanggal</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" id="datepicker" name="tanggal"  value="{{$tanggal ?? ''}}" required>
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
                            <div class="card-body col-6">
                                <h5>Pilih tanggal ramalan</h5>
                                <p class="text-muted">Ramalan akan dilakukan dengan metode dekomposisi aditif dan multiplikatif. Tanggal yang dipilih akan diramal jumlah titik api yang akan muncul pada tanggal tersebut berdasarkan dataset yang sudah ada.</p>
                            </div>
                        </div>
                    </div>
                </div>
                @if (isset($tanggal))
                <div class="card card-tabs">
                    <div class="card-header">
                        <ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="custom-tabs-three-aditif-tab" data-toggle="pill" href="#custom-tabs-three-aditif" role="tab" aria-controls="custom-tabs-three-aditif" aria-selected="true">Aditif</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="custom-tabs-three-multiplikatif-tab" data-toggle="pill" href="#custom-tabs-three-multiplikatif" role="tab" aria-controls="custom-tabs-three-multiplikatif" aria-selected="false">Multiplikatif</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content" id="custom-tabs-three-tabContent">
                            <div class="tab-pane fade show active" id="custom-tabs-three-aditif" role="tabpanel" aria-labelledby="custom-tabs-three-aditif-tab">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th class="text-center" rowspan="2">No</th>
                                            <th class="text-center" rowspan="2">Tanggal / Bulan</th>
                                            <th class="text-center" colspan="{{$allKecamatan->count()}}">Peramalan Jumlah Titik Api</th>
                                            <th class="text-center" rowspan="2">Total</th>
                                        </tr>
                                        <tr>
                                            @foreach ($allKecamatan as $kecamatan)
                                            <td class="text-center">{{$kecamatan->nama}}</td>
                                            @endforeach
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $jumlahAditif = 0; $jumlahMultiplikatif = 0; ?>
                                        @foreach ($uji as $row)
                                        <?php $total = 0 ?>
                                        <tr>
                                            <td class="text-center">{{$loop->iteration}}</td>
                                            <td class="text-center">{{$row->waktu->format('d F Y')}}</td>
                                            @foreach ($allKecamatan as $kecamatan)
                                            <?php $aditif = ($a[$kecamatan->id] * pow($b[$kecamatan->id], $xt[$kecamatan->id])) + ($medial[$kecamatan->id][$row->waktu->format('d-F')] * $penyesuaian[$kecamatan->id]) ?>
                                            <td class="text-center">{{round($aditif)}}</td>
                                            <?php
                                                $xt[$kecamatan->id] = $xt[$kecamatan->id]+1;
                                                $total += round($aditif);
                                            ?>
                                            @endforeach
                                            <td class="text-center">{{($total)}}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="tab-pane fade show" id="custom-tabs-three-multiplikatif" role="tabpanel" aria-labelledby="custom-tabs-three-multiplikatif-tab">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th class="text-center" rowspan="2">No</th>
                                            <th class="text-center" rowspan="2">Tanggal / Bulan</th>
                                            <th class="text-center" colspan="{{$allKecamatan->count()}}">Peramalan Jumlah Titik Api</th>
                                            <th class="text-center" rowspan="2">Total</th>
                                        </tr>
                                        <tr>
                                            @foreach ($allKecamatan as $kecamatan)
                                            <td class="text-center">{{$kecamatan->nama}}</td>
                                            @endforeach
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $jumlahAditif = 0; $jumlahMultiplikatif = 0; ?>
                                        @foreach ($uji as $row)
                                        <?php $total = 0 ?>
                                        <tr>
                                            <td class="text-center">{{$loop->iteration}}</td>
                                            <td class="text-center">{{$row->waktu->format('d F Y')}}</td>
                                            @foreach ($allKecamatan as $kecamatan)
                                            <?php $aditif = ($a[$kecamatan->id] * pow($b[$kecamatan->id], $xt[$kecamatan->id])) * ($medial[$kecamatan->id][$row->waktu->format('d-F')] * $penyesuaian[$kecamatan->id]) ?>
                                            <td class="text-center">{{round($aditif)}}</td>
                                            <?php
                                                $xt[$kecamatan->id] = $xt[$kecamatan->id]+1;
                                                $total += round($aditif);
                                            ?>
                                            @endforeach
                                            <td class="text-center">{{($total)}}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
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
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script>
        $(function () {
          $("#example1").DataTable({
            "autoWidth": true
          });
        });
        $("#datepicker").daterangepicker({
            locale: {
                format: 'DD/MM/YYYY'
            }
        });
    </script>
@endpush
