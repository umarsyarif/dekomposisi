<?php
$title = 'Akurasi';
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
                            <div class="card-header">
                                <form action="{{route('data-uji.page')}}">
                                    <h3 class="card-title mt-2 mr-3">Filter :</h3>
                                    <div class="btn-group mb-2 mr-2" class="in-line">
                                        <select class="custom-select" name="filter">
                                            <option value="" selected>Harian</option>
                                            <option value="bulan" {{$filter == 'bulan' ? 'selected' : ''}}>Bulanan</option>
                                            <option value="tahun" {{$filter == 'tahun' ? 'selected' : ''}}>Tahunan</option>
                                        </select>
                                        <button type="submit" class="btn btn-secondary">
                                            <i class="fas fa-filter"></i>
                                        </button>
                                    </div>
                                    {{-- <div class="btn-group float-right"> --}}
                                        <a href="javascript:void(0);" class="btn btn-primary float-right" data-toggle="modal" data-target="#create-modal">+ Tambah Data</a>
                                        <a href="javascript:void(0);" class="btn btn-warning float-right mr-2" data-toggle="modal" data-target="#import-modal"><i class="fas fa-download mr-2"></i> Import</a>
                                    {{-- </div> --}}
                                </form>
                            </div>
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            @if ($filter == null)
                                                <th>No</th>
                                                <th>Tahun</th>
                                                <th>Jumlah titik api</th>
                                                <th>Created At</th>
                                                <th>Update At</th>
                                            @elseif ($filter == 'tahun')
                                                <th>No</th>
                                                <th>Tahun</th>
                                                <th>Jumlah data</th>
                                                <th>Jumlah titik api</th>
                                                <th>Actions</th>
                                            @elseif ($filter == 'bulan')
                                                <th>No</th>
                                                <th>Bulan</th>
                                                <th>Jumlah data</th>
                                                <th>Jumlah titik api</th>
                                                <th>Actions</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($filter == null)
                                            @foreach ($latih as $row)
                                                <tr>
                                                    <td>{{$loop->iteration}}</td>
                                                    <td>{{$row->waktu->format('d F Y')}}</td>
                                                    <td>{{$row->jumlah}}</td>
                                                    <td>{{$row->created_at->format('d/m/Y H:i')}}</td>
                                                    <td>{{$row->updated_at->format('d/m/Y H:i')}}</td>
                                                </tr>
                                            @endforeach
                                        @elseif ($filter == 'tahun')
                                            @foreach ($latih as $row)
                                                <tr>
                                                    <td>{{$loop->iteration}}</td>
                                                    <td>{{$row->year}}</td>
                                                    <td>{{$row->jumlah->count()}}</td>
                                                    <td>{{$row->jumlah->sum('jumlah')}}</td>
                                                    <td>
                                                        <a href="{{route('data-latih.export', ['tahun' => $row->year])}}" class="btn btn-success">
                                                            <i class="fas fa-upload mr-1"></i> Export
                                                        </a>
                                                        <button class="btn btn-danger" onclick="event.preventDefault();
                                                        document.getElementById('delete-form-{{$row->year}}').submit();">
                                                            <i class="fas fa-trash mr-1"></i> Hapus
                                                        </button>
                                                        <form id="delete-form-{{$row->year}}" action="{{route('data-latih.destroy', ['year' => $row->year, 'filter' => $filter])}}" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @elseif ($filter == 'bulan')
                                                @foreach ($latih as $row)
                                                    <tr>
                                                        <td>{{$loop->iteration}}</td>
                                                        <td>{{date('F', mktime(0, 0, 0, $row->month, 10))}} {{$row->year}}</td>
                                                        <td>{{$row->jumlah->count()}}</td>
                                                        <td>{{$row->jumlah->sum('jumlah')}}</td>
                                                        <td>
                                                            <a href="{{route('data-latih.export', ['tahun' => $row->year])}}" class="btn btn-success disabled">
                                                                <i class="fas fa-upload mr-1"></i> Export
                                                            </a>
                                                            <button class="btn btn-danger" onclick="event.preventDefault();
                                                            document.getElementById('delete-form-{{$row->year}}').submit();" disabled>
                                                                <i class="fas fa-trash mr-1"></i> Hapus
                                                            </button>
                                                            <form id="delete-form-{{$row->year}}" action="{{route('data-latih.destroy', ['year' => $row->year, 'filter' => $filter])}}" method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                            </form>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Modal Create -->
                <div class="modal fade" id="create-modal" tabindex="-1" role="dialog" aria-labelledby="create-modal-label" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="create-modal-label">Tambah Data Uji</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="{{route('data-uji.store')}}" method="post">
                            @csrf
                            <div class="modal-body">
                                <input type="hidden" name="filter" value="{{$filter}}">
                                <div class="form-group">
                                    <label for="datepicker">Bulan</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="datepicker" name="bulan" placeholder="Pilih bulan" required>
                                        <div class="input-group-append">
                                            <span class="input-group-text">
                                                <i class="fas fa-calendar"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Tambah</button>
                            </div>
                        </form>
                    </div>
                    </div>
                </div>
                <!-- Modal Create -->
                <!-- Modal Tahun -->
                <div class="modal fade" id="import-modal" tabindex="-1" role="dialog" aria-labelledby="import-modal-label" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="import-modal-label">Import Data Uji</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="{{route('data-uji.import')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="filter" value="{{$filter}}">
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="file">Upload File</label>
                                    <div class="input-group mb-3">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="file" name="file" required>
                                            <label class="custom-file-label" for="file">Choose file (.xls)</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
                    </div>
                </div>
                <!-- Modal Tahun -->
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

        $(function () {
          $("#example1").DataTable({
            "autoWidth": true
          });
        });

        $("#datepicker").datepicker({
            format: "M-yyyy",
            minViewMode : 1,
            autoclose : true
        });

    </script>
@endpush
