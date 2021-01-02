<?php
$title = 'Datasets';
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
                    <div class="card-header">
                        <i class="fas fa-filter mr-2"></i>
                        <h5 class="d-inline">Filter</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{route('dataset.page')}}">
                        <div class="col-12 row">
                                <div class="col-6 form-group row">
                                    <label for="filter" class="col-sm-3 col-form-label">Waktu</label>
                                    <div class="col-sm-9">
                                        <select class="custom-select" name="filter">
                                            <option value="" selected>Harian</option>
                                            <option value="bulan" {{$filter == 'bulan' ? 'selected' : ''}}>Bulanan</option>
                                            <option value="tahun" {{$filter == 'tahun' ? 'selected' : ''}}>Tahunan</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6 form-group row">
                                    <label for="kecamatan" class="col-sm-3 col-form-label">Kecamatan</label>
                                    <div class="col-sm-9">
                                        <select class="custom-select" name="kecamatan">
                                            <option value="" selected>All</option>
                                            @foreach ($allKecamatan as $row)
                                            <option value="{{$row->id}}" {{$kecamatan == $row->id ? 'selected' : ''}}>{{$row->nama}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary float-right">Filter</button>
                        </form>
                    </div>
                </div>
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
                <div class="card">
                    <div class="card-header">
                        <a href="javascript:void(0);" class="btn btn-success float-right" data-toggle="modal" data-target="#create-modal">+ Tambah Data</a>
                        <a href="javascript:void(0);" class="btn btn-warning float-right mr-2" data-toggle="modal" data-target="#import-modal"><i class="fas fa-download mr-2"></i> Import</a>
                    </div>
                    <div class="card-body">
                        <h4 class="text-center">Data Jumlah Titik Api</h4>
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    @if ($filter == null)
                                        <th>No</th>
                                        <th class="text-center">Tanggal</th>
                                        <th class="text-center">Jumlah titik api</th>
                                        <th class="text-center">Kecamatan</th>
                                        <th>Created At</th>
                                        <th>Updated At</th>
                                    @elseif ($filter == 'tahun')
                                        <th>No</th>
                                        <th>Tahun</th>
                                        <th>Jumlah data</th>
                                        <th>Jumlah titik api</th>
                                        <th>Actions</th>
                                    @elseif ($filter == 'bulan')
                                        <th>No</th>
                                        <th>Bulan/Tahun</th>
                                        <th>Jumlah data</th>
                                        <th>Jumlah titik api</th>
                                        <th>Actions</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @if ($filter == null)
                                    @foreach ($dataset as $row)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td class="text-center">{{$row->waktu->format('d F Y')}}</td>
                                            <td class="text-center"><a href="javascript:void(0)" class="jumlah" data-type="text" data-pk="{{$row->id}}" data-url="/api/dataset/{{$row->id}}" data-name="jumlah" data-title="Jumlah Titik Api">{{$row->jumlah}}</a></td>
                                            <td class="text-center">{{$row->kecamatan->nama}}</td>
                                            <td>{{$row->created_at->format('d/m/Y H:i')}}</td>
                                            <td>{{$row->updated_at->format('d/m/Y H:i')}}</td>
                                        </tr>
                                    @endforeach
                                @elseif ($filter == 'tahun')
                                    @foreach ($dataset as $row)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{$row->year}}</td>
                                            <td>{{$row->jumlah->count()}}</td>
                                            <td>{{$row->jumlah->sum('jumlah')}}</td>
                                            <td>
                                                <a href="{{route('dataset.export', ['tahun' => $row->year])}}" class="btn btn-warning">
                                                    <i class="fas fa-upload mr-1"></i> Export
                                                </a>
                                                <button class="btn btn-danger" onclick="deleteByYear({{$row->year}})">
                                                    <i class="fas fa-trash mr-1"></i> Hapus
                                                </button>
                                                <form id="delete-form-{{$row->year}}" action="{{route('dataset.destroy', ['year' => $row->year, 'filter' => $filter])}}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                @elseif ($filter == 'bulan')
                                        @foreach ($dataset as $row)
                                            <tr>
                                                <td>{{$loop->iteration}}</td>
                                                <td>{{date('F', mktime(0, 0, 0, $row->month, 10))}} {{$row->year}}</td>
                                                <td>{{$row->jumlah->count()}}</td>
                                                <td>{{$row->jumlah->sum('jumlah')}}</td>
                                                <td>
                                                    <a href="{{route('dataset.export', ['bulan' => $row->month, 'tahun' => $row->year])}}" class="btn btn-warning">
                                                        <i class="fas fa-upload mr-1"></i> Export
                                                    </a>
                                                    <button class="btn btn-danger" onclick="deleteByMonth({{$row->month}},{{$row->year}})">
                                                        <i class="fas fa-trash mr-1"></i> Hapus
                                                    </button>
                                                    <form id="delete-form-{{$row->month}}-{{$row->year}}" action="{{route('dataset.destroy', ['month' => $row->month, 'year' => $row->year, 'filter' => $filter])}}" method="POST">
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
                <!-- Modal Create -->
                <div class="modal fade" id="create-modal" tabindex="-1" role="dialog" aria-labelledby="create-modal-label" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="create-modal-label">Tambah Dataset</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="{{route('dataset.store')}}" method="post">
                            @csrf
                            <div class="modal-body">
                                <input type="hidden" name="filter" value="{{$filter}}">
                                <div class="form-group">
                                    <label for="new">Tambah data :</label>
                                    <select name="new" id="new" class="form-control custom-select">
                                        <option value="bulanan">Bulanan</option>
                                        <option value="tahunan">Tahunan</option>
                                    </select>
                                </div>
                                <div class="form-group mt-3" id="month">
                                    <label for="monthpicker">Bulan</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="bulan" id="monthpicker" placeholder="Pilih bulan" required>
                                        <div class="input-group-append">
                                            <span class="input-group-text">
                                                <i class="fas fa-calendar"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group d-none" id="year">
                                    <label for="yearpicker">Tahun</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="tahun" id="yearpicker" placeholder="Pilih tahun">
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
                            <h5 class="modal-title" id="import-modal-label">Import Dataset</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="{{route('dataset.import')}}" method="post" enctype="multipart/form-data">
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
    <script type="text/javascript" src="{{asset('x-editable/bootstrap-editable.min.js')}}"></script>
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

        $("#monthpicker").datepicker({
            format: "M-yyyy",
            minViewMode : 1,
            autoclose : true
        });

        $("#yearpicker").datepicker({
            format: "yyyy",
            viewMode: "years",
            minViewMode: "years",
            autoclose: true
        });

        $('#new').on('change', function(){
            // alert(this.value);
            if(this.value == 'tahunan' ){
                $('#year').removeClass('d-none');
                $('#month').addClass('d-none');
                $('#yearpicker').attr('required', true);
                $('#monthpicker').removeAttr('required');
            } else if (this.value == 'bulanan' ){
                $('#year').addClass('d-none');
                $('#month').removeClass('d-none');
                $('#monthpicker').attr('required', true);
                $('#yearpicker').removeAttr('required');
            }
        });

        $.fn.editable.defaults.mode = 'inline';
        $('.jumlah').editable('option', 'validate', function(v) {
            if(!v) {
                Toast.fire({
                    icon: 'warning',
                    title: 'Jumlah tidak boleh kosong!'
                });
                return '.';
            }else{
                Toast.fire({
                    icon: 'success',
                    title: 'Data berhasil disimpan!'
                });
            }
        });

        function deleteByYear(year){
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            })
            .then((result) => {
                if (result.value) {
                    $('#delete-form-'+year).submit();
                }
            });
        }

        function deleteByMonth(month, year){
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            })
            .then((result) => {
                if (result.value) {
                    $('#delete-form-'+month+'-'+year).submit();
                }
            });
        }

    </script>
@endpush
