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
                                <h5 class="text-center mb-5">MENGGUNAKAN METODE DEKOMPOSISI</h5>
                                <p class="card-text">
                                    kebakaran hutan merupakan suatu keadaan dimana hutan di landa api yang kemudian
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
                                <a href="javascript:void(0);" class="btn btn-primary float-right mt-3" data-toggle="modal" data-target="#start-modal">Start</a>
                            </div>
                        </div>
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
