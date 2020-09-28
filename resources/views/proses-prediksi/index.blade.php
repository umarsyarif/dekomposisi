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
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="text-center">SISTEM PERAMALAN JUMLAH KEMUNCULAN TITIK API DI RIAU</h4>
                                <h5 class="text-center mb-5">Menggunakan Metode Dekomposisi</h5>
                                <p class="card-text">
                                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Exercitationem tempore, eaque quam sint ea officia impedit, doloremque soluta, aperiam neque magni repudiandae fugiat minima facilis velit! Tenetur voluptatibus voluptate soluta.
                                </p>
                                <p class="card-text">
                                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Exercitationem tempore, eaque quam sint ea officia impedit, doloremque soluta, aperiam neque magni repudiandae fugiat minima facilis velit! Tenetur voluptatibus voluptate soluta.
                                </p>
                                <p class="card-text">
                                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Exercitationem tempore, eaque quam sint ea officia impedit, doloremque soluta, aperiam neque magni repudiandae fugiat minima facilis velit! Tenetur voluptatibus voluptate soluta.
                                </p>
                                {{-- <div class="col-12">
                                    <form action="" method="post">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <input type="text" class="form-control" id="datepicker" name="tanggal" placeholder="Pilih tanggal" required>
                                                <div class="input-group-append">
                                                    <button type="submit" class="btn btn-primary">Check</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div> --}}
                                <a href="javascript:void(0);" class="btn btn-primary float-right mt-3" data-toggle="modal" data-target="#start-modal">Mulai</a>
                                {{-- <a href="{{route('prediksi.hasil')}}" class="btn btn-primary float-right mt-3">Start</a> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal Create -->
        <div class="modal fade" id="start-modal" tabindex="-1" role="dialog" aria-labelledby="start-modal-label" aria-hidden="true">
            <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="start-modal-label">Peramalan Titik Api</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{route('prediksi.hasil')}}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="datepicker">Tanggal</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="datepicker" name="tanggal" placeholder="Pilih tanggal" required>
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <i class="fas fa-calendar"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        {{-- <small class="text-muted"><em>*)Tanggal yang dipilih harus memiliki data aktual</em></small> --}}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Check</button>
                    </div>
                </form>
            </div>
            </div>
        </div>
        <!-- Modal Create -->
    </div>
</div>
@endsection
@push('scripts')
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script>

        $("#datepicker").daterangepicker({
            locale: {
                format: "DD/MM/YYYY"
            },
            startDate: "01/01/2020",
            endDate: "01/01/2020",
        });

    </script>
@endpush
