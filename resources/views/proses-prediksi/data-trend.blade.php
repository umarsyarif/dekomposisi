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
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <button class="btn btn-primary float-right" data-toggle="modal" data-target="#modal-hasil">
                                    <i class="fas fa-file mr-1"></i> Hasil
                                </button>
                            </div>
                            <div class="card-body">
                                <h4 class="text-center">Data Nilai Trend</h4>
                                <table id="trend" class="table table-bordered table-striped">
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
                                                <td class="text-center">{{$y = $row->jumlah}}</td>
                                                <td class="text-center replace"></td>
                                                <td class="text-center replace"></td>
                                                <td class="text-center replace"></td>
                                                <td class="text-center replace"></td>
                                                <td class="text-center replace"></td>
                                                <td class="text-center replace"></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Modal -->
                @if ($data->count() > 0)
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
                                                <h6 class="text-center" id="a"></h6>
                                            </div>
                                            <div class="bg-info col-6 pt-1">
                                                <h6 class="text-center" id="b"></h6>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="row mt-3">
                                            <div class="bg-success col-12 pt-1">
                                                <h6 class="text-center" id="y"></h6>
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
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
    <script>

        // $(function () {
        //   $("#example1").DataTable({
        //     "autoWidth": true
        //   });
        // });

    </script>
    @if ($data->count() > 0)
        <script>

        $(document).ready(()=>{
            getTrend().then(() => {console.log('Data Trend')});
        });

        const getTrend = async () => {
            $('.replace').remove();
            const dataLatih = {!! json_encode($data->toArray()) !!};
            const split = _.size(dataLatih) / 2;
            let iteration = 0;
            let logy = 0, xlogy = 0, x2 = 0;
            $.each(dataLatih, (index, value) => {
                let temp, x, y = value.jumlah, a = 0, b = 0;
                let log10y = Math.log10(y);
                temp += `<td class="text-center">${x = getX(iteration, split)}</td>`;
                temp += `<td class="text-center">${y != 0 ? x * y : 0}</td>`;
                temp += `<td class="text-center">${Math.pow(x, 2)}</td>`;
                temp += `<td class="text-center">${Math.pow(y, 2)}</td>`;
                temp += `<td class="text-center">${isFinite(log10y) ? a = log10y.toFixed(3) : a = 0}</td>`;
                temp += `<td class="text-center">${isFinite(log10y) ? b = (x * a).toFixed(3) : b = 0}</td>`;
                x2 += Math.pow(x, 2);
                logy += parseFloat(a);
                xlogy += parseFloat(b);
                iteration++;
                $('#trend-tr-'+iteration).append(temp);
            });
            let a = Math.pow(10, logy / _.size(dataLatih)).toFixed(9);
            let b = Math.pow(10, xlogy / x2).toFixed(9);
            console.log(a, b);
            $('#a').append(`<strong><em>a</em> = ${a}</strong>`);
            $('#b').append(`<strong><em>b</em> = ${b}</strong>`);
            $('#y').append(`<strong><em>Y</em> = (${a}) (${b}) <em><sup>x</sup></em></strong>`);
            $('#trend').DataTable({
                "autoWidth": true
            });
        }

        const getX = (iteration, split) =>{
            const current = iteration - Math.round(split);
            console.log(split * 2 % 2);
            if (split * 2 % 2 == 0){
                return  current * 2 + 1;
            }
            return current + 1;
        }

        </script>
    @endif
@endpush
