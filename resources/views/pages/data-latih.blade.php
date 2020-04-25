<?php
$title = 'Data Latih';
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
                                    Lorem ipsum dolor, sit amet consectetur adipisicing elit. Rerum ipsam quia ducimus, explicabo harum amet expedita non. Quis labore iste saepe voluptas, hic voluptatem sapiente, itaque eos, et eaque expedita.
                                    Lorem, ipsum dolor sit amet consectetur adipisicing elit. Expedita consequuntur et doloremque quos! Porro, laboriosam eveniet blanditiis distinctio laborum quam ut. Suscipit quod recusandae eaque voluptatibus itaque praesentium facere similique.
                                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Corporis quisquam suscipit in assumenda inventore nulla id labore unde rerum doloribus, repellendus repellat quibusdam ducimus aliquam voluptates similique dolorum accusamus amet.
                                    Lorem ipsum, dolor sit amet consectetur adipisicing elit. Animi odit sit velit quos qui, expedita sequi iusto aliquid ea perferendis quas, voluptates dolorem eveniet deleniti laborum officia, nulla nesciunt consequuntur?
                                </p>
                                <a href="#" class="btn btn-primary float-right mt-3">Start</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
