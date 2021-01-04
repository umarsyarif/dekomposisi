<?php
$title = 'Kecamatan';
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
                                <form action="{{route('dataset.page')}}">
                                    <a href="javascript:void(0);" class="btn btn-success float-right" data-toggle="modal" data-target="#create-modal">+ Tambah Data</a>
                                </form>
                            </div>
                            <div class="card-body">
                                <h4 class="text-center">Data Kecamatan</h4>
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th class="text-center">Nama</th>
                                            <th class="text-center">Jumlah Dataset</th>
                                            <th class="text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($kecamatan as $row)
                                            <tr>
                                                <td>{{$loop->iteration}}</td>
                                                <td class="text-center">{{$row->nama}}</td>
                                                <td class="text-center">{{$row->jumlah_dataset}}</td>
                                                <td class="text-center">
                                                    <button class="btn btn-warning btn-edit" data-form="{{ $row }}"><i class="fas fa-edit"></i> Ubah</button>
                                                    <button class="btn btn-danger" onclick="destroy({{$row->id}})">
                                                        <i class="fas fa-trash mr-1"></i> Hapus
                                                    </button>
                                                    <form id="delete-form-{{$row->id}}" action="{{route('kecamatan.destroy', $row->id)}}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
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
                            <h5 class="modal-title" id="create-modal-label">Tambah Kecamatan</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form id="form-create-modal" action="{{route('kecamatan.store')}}" method="post">
                            @csrf
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="new">Nama :</label>
                                    <input type="text" id="nama" name="nama" class="form-control" required>
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
                <!-- Modal Create -->
                <!-- Modal Edit -->
                <div class="modal fade" id="edit-modal" tabindex="-1" role="dialog" aria-labelledby="edit-modal-label" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="edit-modal-label">Ubah Kecamatan</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form id="form-edit-modal" action="" method="post">
                            @csrf
                            @method('PUT')
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="new">Nama :</label>
                                    <input type="text" id="edit-nama" name="nama" class="form-control" required>
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
                <!-- Modal Edit -->
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
    <script type="text/javascript" src="{{asset('x-editable/bootstrap-editable.min.js')}}"></script>
    <script>

        const url = "{{ route('kecamatan.page') }}"

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

        $('.btn-edit').click(function() {
            $('#edit-modal').modal('show');

            const form = $(this).data('form');
            $('#edit-nama').val(form.nama);

            const updateUrl = url+'/'+form.id;
            $('#form-edit-modal').attr('action', updateUrl);
        });

        function destroy(id){
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
                    $('#delete-form-'+id).submit();
                }
            });
        }

    </script>
@endpush
