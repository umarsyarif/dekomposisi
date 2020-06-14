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
                @if ($message = Session::get('success'))
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4><i class="icon fa fa-check"></i> Success!</h4>
                    {{ $message }}
                  </div>
                @endif
                @if ($message = Session::get('error'))
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4><i class="icon fa fa-exclamation-triangle"></i> Failed!</h4>
                    {{ $message }}
                  </div>
                @endif
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="text-center mb-5">Upload Data Latih</h4>
                                <div class="card-body col-6 mx-auto">
                                    <form action="{{route('api.export')}}" method="get">
                                        <div class="form-group">
                                            <label for="tahun">Template Excel</label>
                                            <select id="tahun" name="tahun" class="form-control">
                                                <option selected>Pilih Tahun...</option>
                                                <option value="2016">2016</option>
                                                <option value="2017">2017</option>
                                                <option value="2018">2018</option>
                                            </select>
                                            <button type="submit" class="btn btn-primary my-3">Download</button>
                                        </div>
                                    </form>
                                    <form action="{{route('api.import')}}" method="post" enctype="multipart/form-data">
                                        @csrf
                                        <div class="form-group">
                                            <label for="file">Upload Data</label>
                                            <div class="input-group mb-3">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="file" name="file">
                                                    <label class="custom-file-label" for="file">Choose file</label>
                                                </div>
                                            </div>
                                            <button type="submit" class="btn btn-primary">Save</button>
                                        </div>
                                    </form>
                                </div>
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
        $('#file').on('change',function(){
            //get the file name
            var fileName = $(this).val().replace('C:\\fakepath\\', "");
            //replace the "Choose a file" label
            $(this).next('.custom-file-label').html(fileName);
        })

        axios.get('/api/get-year')
        .then(response => {
            console.log.response;
        }).catch(error => {
            console.error(error)
        });
    </script>
@endpush
