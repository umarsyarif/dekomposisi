<?php
$title = 'Pengujian';
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
                                <h5 class="text-center mb-5">MENGGUNAKAN METODE DEKOMPOSISI</h5>
                                <p class="card-text">
                                    Kebakaran hutan merupakan suatu keadaan dimana hutan di landa api yang kemudian
                                    mengakibatkan rusaknya hutan dan menimbulkan kerugian ekonomis terhadap hasil hutan dan
                                    atau nilai lingkungan. Selain faktor curah hujan yang menjadi indikator yang paling utama
                                    sebagai pemicu kebakaran di Indonesia, Titik Panas (Hotspot) juga merupakan indikator
                                    kebakaran hutan. Berdasarkan Data yang dikeluarkan oleh BNPB pada tahun 2019, Masalah
                                    bencana yang terjadi di Indonesia salah satunya adalah terbakarnya luas lahan. Data KLHK
                                    mencatat luas karhutla dari bulan Januri hingga bulan September 2019 yaitu sebesar 857.756 ha.
                                    Data BNPB juga mencatat masih terjadi karhutla di sejumlah wilayah Indonesia pada bulan
                                    Oktober 2019. Titik panas atau Hotspot teridentifikasi di beberapa provinsi. Salah satunya pada
                                    Provinsi Riau. Berdasarkan masalah yang telah dijelaskan, maka akan dibangun sebuah aplikasi
                                    peramalan jumlah kemunculan titik api yang merupakan salah satu proses penanggulangan
                                    kebakaran hutan agar berkurangnya bencana kebakaran hutan dan lahan di Indonesia khususnya
                                    pada Provinsi Riau. Aplikasi yang akan dibangun menggunakan metode Dekomposisi berbasis
                                    web yang akan di implementasikan menggunakan bahasa pemrograman PHP. Data latih yang
                                    akan digunakan yaitu data jumlah titik api di Provinsi Riau pada tahun 2014-2019 dan data uji
                                    adalah data bulan Januari tahun 2020 yang diperoleh dari Lembaga Penerbangan Antariksa
                                    Nasional (LAPAN). Pengujian dilakukan dengan pengujian black box dan pengujian akurasi
                                    sistem menggunakan Mean Absolute Percent Error (MAPE).
                                </p>
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
        // $('#file').on('change',function(){
        //     //get the file name
        //     var fileName = $(this).val().replace('C:\\fakepath\\', "");
        //     //replace the "Choose a file" label
        //     $(this).next('.custom-file-label').html(fileName);
        // })

        // $(function () {
        //   $("#example1").DataTable({
        //     "autoWidth": true
        //   });
        // });

        $("#datepicker").daterangepicker();

    </script>
@endpush
