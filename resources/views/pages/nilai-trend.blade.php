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
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            @if ($kecamatan)
                            <div class="card-body col-6">
                                <p class="text-center">Rumus Nilai Trend :</p>
                                <h5 class="text-center border"><strong><em>Y = a b<sup>x</sup></em></strong></h5>
                                <div class="col-12">
                                    <div class="row mt-3">
                                        <div class="border col-6 pt-1">
                                            <h6 class="text-center" id="a"><strong><em>a</em> = {{$a ?? '' ?? ''}} </strong></h6>
                                        </div>
                                        <div class="border col-6 pt-1">
                                            <h6 class="text-center" id="b"><strong><em>b</em> = {{$b ?? '' ?? ''}} </strong></h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="row mt-3">
                                        <div class="border col-12 pt-1">
                                            <h6 class="text-center" id="y"><strong><em>Y</em> = ({{$a ?? ''}}) ({{$b ?? ''}}) <em><sup>x</sup></em></strong></h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                            <div class="card-body col-6">
                                <h5>Nilai Trend</h5>
                                <p class="text-muted">Untuk mencari nilai komponen Trend pada proses Dekomposisi, digunakan salah satu metode trend yaitu metode trend exponential.</p>
                            </div>
                        </div>
                    </div>
                </div>
                @if ($kecamatan)
                <div class="card">
                    <div class="card-header">
                        <form action="{{route('dekomposisi.trend')}}">
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
                    <div class="card-body">
                        <h4 class="text-center">Nilai Trend</h4>
                        <table id="trend" class="table datatable table-bordered table-striped">
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
                                @foreach ($data as $row)
                                    <tr id="trend-tr-{{$loop->iteration}}">
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$row->waktu->format('d F Y')}}</td>
                                        <td class="text-center">{{$row->y}}</td>
                                        <td class="text-center">{{$row->x}}</td>
                                        <td class="text-center">{{$row->xy}}</td>
                                        <td class="text-center">{{$row->x2}}</td>
                                        <td class="text-center">{{$row->y2}}</td>
                                        <td class="text-center">{{$row->logy}}</td>
                                        <td class="text-center">{{$row->xlogy}}</td>
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
                        <form action="{{route('dekomposisi.trend')}}">
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
                <!-- Modal -->
                @if ( count($data) > 0 )
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
                                                <h6 class="text-center" id="a"><strong><em>a</em> = {{$a ?? ''}} </strong></h6>
                                            </div>
                                            <div class="bg-info col-6 pt-1">
                                                <h6 class="text-center" id="b"><strong><em>b</em> = {{$b ?? ''}} </strong></h6>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="row mt-3">
                                            <div class="bg-success col-12 pt-1">
                                                <h6 class="text-center" id="y"><strong><em>Y</em> = ({{$a ?? ''}}) ({{$b ?? ''}}) <em><sup>x</sup></em></strong></h6>
                                            </div>
                                        </div>
                                    </div>
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
          $(".datatable").DataTable({
            "autoWidth": true
          });
        });

    </script>
@endpush
