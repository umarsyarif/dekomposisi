<?php
$title = 'Pembagian Data';
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
                        <h5>Membagi Dataset</h5>
                        <p class="text-muted">Membagi datasets menjadi <em>data latih</em> dan <em>data uji</em>. Untuk data tahun terakhir pada datasets akan dijadikan data uji, sedangkan selebihnya akan menjadi data latih.</p>
                    </div>
                </div>
                @if ($kecamatan)
                <div class="card card-primary card-outline card-tabs">
                    <div class="card-header p-0 border-bottom-0">
                        <form action="{{route('dataset.devide')}}" class="mt-2">
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
                        <ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="custom-tabs-three-latih-tab" data-toggle="pill" href="#custom-tabs-three-latih" role="tab" aria-controls="custom-tabs-three-latih" aria-selected="true">Data Latih</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="custom-tabs-three-uji-tab" data-toggle="pill" href="#custom-tabs-three-uji" role="tab" aria-controls="custom-tabs-three-uji" aria-selected="false">Data Uji</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content" id="custom-tabs-three-tabContent">
                            <div class="tab-pane fade show active" id="custom-tabs-three-latih" role="tabpanel" aria-labelledby="custom-tabs-three-latih-tab">
                                <table id="latih" class="table datatable table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th class="text-center">Tanggal</th>
                                            <th class="text-center">Jumlah titik api</th>
                                            <th>Created At</th>
                                            <th>Update At</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($dataLatih as $row)
                                            <tr>
                                                <td>{{$loop->iteration}}</td>
                                                <td class="text-center">{{$row->waktu->format('d F Y')}}</td>
                                                <td class="text-center"><a href="javascript:void(0)" class="jumlah">{{$row->jumlah}}</a></td>
                                                <td>{{$row->created_at->format('d/m/Y H:i')}}</td>
                                                <td>{{$row->updated_at->format('d/m/Y H:i')}}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="tab-pane fade" id="custom-tabs-three-uji" role="tabpanel" aria-labelledby="custom-tabs-three-uji-tab">
                                <table id="uji" class="table datatable table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th class="text-center">Tanggal</th>
                                            <th class="text-center">Jumlah titik api</th>
                                            <th>Created At</th>
                                            <th>Update At</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($dataUji as $row)
                                            <tr>
                                                <td>{{$loop->iteration}}</td>
                                                <td class="text-center">{{$row->waktu->format('d F Y')}}</td>
                                                <td class="text-center"><a href="javascript:void(0)" class="jumlah">{{$row->jumlah}}</a></td>
                                                <td>{{$row->created_at->format('d/m/Y H:i')}}</td>
                                                <td>{{$row->updated_at->format('d/m/Y H:i')}}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                @else
                <div class="card">
                    <div class="card-header">
                        Kecamatan
                    </div>
                    <div class="card-body">
                        <form action="{{route('dataset.devide')}}">
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
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script>

        $(function () {
          $(".datatable").DataTable({
            "autoWidth": true
          });
        });

    </script>
@endpush
