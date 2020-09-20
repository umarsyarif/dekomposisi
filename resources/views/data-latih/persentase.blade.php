<?php
$title = 'Data Training';
?>
@extends('layouts.main')

@section('title', $title)

@section('content')
<div id="app">
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/nprogress@0.2.0/nprogress.css" />
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
                    @if (!$persen = Request::get('persentase'))
                        <div class="col-lg-12" id="start">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="text-center">PEMBAGIAN DATASET BERDASARKAN PERSENTASE</h4>
                                    <h5 class="text-center mb-5">untuk menentukan persentase terbaik</h5>
                                    <p class="card-text">
                                        Lorem ipsum dolor sit amet consectetur, adipisicing elit. Totam nemo deleniti perferendis tempore animi sequi enim voluptatum. Officia minus doloremque error reiciendis asperiores, nemo modi ratione odio velit quidem dolorum.
                                    </p>
                                    <div class="col-12">
                                        <div class="row">
                                            <div class="col-lg-3 col-md-6">
                                                <div class="card text-">
                                                    <div class="card-body mt-3">
                                                        <p class="text-center text-secondary">Persentase Dataset</p>
                                                        <h4 class="text-center text-yellow"><strong>{{ $persentase = "90 : 10" }}</strong></h4>
                                                        <p class="text-center text-secondary">Data Latih : Data Uji</p>
                                                        <a href="{{route('data-latih.persentase', ['persentase' => $persentase])}}" class="btn btn-primary w-100 mt-3">Check</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-6">
                                                <div class="card text-">
                                                    <div class="card-body mt-3">
                                                        <p class="text-center text-secondary">Persentase Dataset</p>
                                                        <h4 class="text-center text-yellow"><strong>{{ $persentase = "90 : 10" }}</strong></h4>
                                                        <p class="text-center text-secondary">Data Latih : Data Uji</p>
                                                        <a href="{{route('data-latih.persentase', ['persentase' => $persentase])}}" class="btn btn-primary w-100 mt-3">Check</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-6">
                                                <div class="card text-">
                                                    <div class="card-body mt-3">
                                                        <p class="text-center text-secondary">Persentase Dataset</p>
                                                        <h4 class="text-center text-yellow"><strong>{{ $persentase = "90 : 10" }}</strong></h4>
                                                        <p class="text-center text-secondary">Data Latih : Data Uji</p>
                                                        <a href="{{route('data-latih.persentase', ['persentase' => $persentase])}}" class="btn btn-primary w-100 mt-3">Check</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-6">
                                                <div class="card text-">
                                                    <div class="card-body mt-3">
                                                        <p class="text-center text-secondary">Persentase Dataset</p>
                                                        <h4 class="text-center text-yellow"><strong>{{ $persentase = "90 : 10" }}</strong></h4>
                                                        <p class="text-center text-secondary">Data Latih : Data Uji</p>
                                                        <a href="{{route('data-latih.persentase', ['persentase' => $persentase])}}" class="btn btn-primary w-100 mt-3">Check</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- <a href="javascript:void(0);" class="btn btn-primary float-right mt-3" data-toggle="modal" data-target="#start-modal">Mulai</a> --}}
                                    {{-- <a href="{{route('prediksi.hasil')}}" class="btn btn-primary float-right mt-3">Start</a> --}}
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="col-lg-12" id="persen">
                            <div class="card">
                                <div class="card-body pb-0">
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h5 class="text-center">Persentase Dataset</h5>
                                                </div>
                                                <div class="card-body">
                                                    <canvas id="donutChart" style="height:230px; min-height:230px"></canvas>
                                                </div>
                                                <p class="text-center text-secondary mb-0"><strong>{{ $dataLatih->count() }} : {{ $dataUji->count() }}</strong></p>
                                                <p class="text-center text-secondary">Data Latih : Data Uji</p>
                                                <div class="card-footer bg-white">
                                                    <p class="text-center mb-0">Total <strong>{{ $dataUji->count() + $dataLatih->count() }}</strong> data</p>
                                                </div>
                                            </div>
                                            <br>
                                        </div>
                                        <div class="col-lg-8">
                                            <div class="card-body">
                                                <h3 class="mb-3"><strong>Judul</strong></h3>
                                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Porro dolore ipsa nostrum dolores quia iusto quaerat voluptates inventore? Reiciendis ratione, aspernatur et iusto sit sunt libero ipsa unde ad officiis!</p>
                                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Deserunt ipsum sit quaerat minus itaque asperiores, aperiam dolore? Nihil explicabo distinctio, saepe quasi exercitationem voluptas, quod cupiditate esse accusamus temporibus culpa?</p>
                                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Tempore non earum, cum, iusto animi perspiciatis esse minus itaque commodi facere eum velit quod quae, aliquid blanditiis ullam nobis qui eveniet.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="card card-primary card-outline card-outline-tabs">
                                <div class="card-header p-0 border-bottom-0">
                                    <ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="custom-tabs-three-latih-tab" data-toggle="pill" href="#custom-tabs-three-latih" role="tab" aria-controls="custom-tabs-three-latih" aria-selected="true">Data Latih</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="custom-tabs-three-uji-tab" data-toggle="pill" href="#custom-tabs-three-uji" role="tab" aria-controls="custom-tabs-three-uji" aria-selected="false">Data Uji</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="custom-tabs-three-trend-tab" data-toggle="pill" href="#custom-tabs-three-trend" role="tab" aria-controls="custom-tabs-three-trend" aria-selected="false">Nilai Trend</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="custom-tabs-three-musiman-tab" data-toggle="pill" href="#custom-tabs-three-musiman" role="tab" aria-controls="custom-tabs-three-musiman" aria-selected="false">Nilai Indeks Musiman</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="custom-tabs-three-hasil-tab" data-toggle="pill" href="#custom-tabs-three-hasil" role="tab" aria-controls="custom-tabs-three-hasil" aria-selected="false">Hasil Prediksi</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="card-body">
                                    <div class="tab-content" id="custom-tabs-three-tabContent">
                                        <div class="tab-pane fade show active" id="custom-tabs-three-latih" role="tabpanel" aria-labelledby="custom-tabs-three-latih-tab">
                                            <table id="example1" class="table datatable table-bordered table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th class="text-center">Tanggal</th>
                                                        <th class="text-center">Jumlah Titik Api</th>
                                                        <th>Created At</th>
                                                        <th>Updated At</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($dataLatih as $row)
                                                        <tr>
                                                            <td>{{$loop->iteration}}</td>
                                                            <td class="text-center">{{$row->waktu->format('d F Y')}}</td>
                                                            <td class="text-center"><a href="javascript:void(0)" class="jumlah" data-type="text" data-pk="{{$row->id}}" data-url="/api/latih/{{$row->id}}" data-name="jumlah" data-title="Jumlah Titik Api">{{$row->jumlah}}</a></td>
                                                            <td>{{$row->created_at->format('d/m/Y H:i')}}</td>
                                                            <td>{{$row->updated_at->format('d/m/Y H:i')}}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="tab-pane fade" id="custom-tabs-three-uji" role="tabpanel" aria-labelledby="custom-tabs-three-uji-tab">
                                            <table id="example2" class="table datatable table-bordered table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th class="text-center">Tanggal</th>
                                                        <th class="text-center">Jumlah Titik Api</th>
                                                        <th>Created At</th>
                                                        <th>Updated At</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($dataUji as $row)
                                                        <tr>
                                                            <td>{{$loop->iteration}}</td>
                                                            <td class="text-center">{{$row->waktu->format('d F Y')}}</td>
                                                            <td class="text-center"><a href="javascript:void(0)" class="jumlah" data-type="text" data-pk="{{$row->id}}" data-url="/api/latih/{{$row->id}}" data-name="jumlah" data-title="Jumlah Titik Api">{{$row->jumlah}}</a></td>
                                                            <td>{{$row->created_at->format('d/m/Y H:i')}}</td>
                                                            <td>{{$row->updated_at->format('d/m/Y H:i')}}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="tab-pane fade" id="custom-tabs-three-trend" role="tabpanel" aria-labelledby="custom-tabs-three-trend-tab">
                                            <table id="trend-table" class="table table-bordered table-striped">
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
                                                    @foreach ($dataLatih as $row)
                                                        <tr id="trend-tr-{{ $loop->iteration }}">
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td class="text-center">{{ $row->waktu->format('d F Y') }}</td>
                                                            <td class="text-center">{{ $row->jumlah }}</td>
                                                            <td class="trend"></td>
                                                            <td class="trend"></td>
                                                            <td class="trend"></td>
                                                            <td class="trend"></td>
                                                            <td class="trend"></td>
                                                            <td class="trend"></td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="tab-pane fade" id="custom-tabs-three-musiman" role="tabpanel" aria-labelledby="custom-tabs-three-musiman-tab">
                                            asd
                                        </div>
                                        <div class="tab-pane fade" id="custom-tabs-three-hasil" role="tabpanel" aria-labelledby="custom-tabs-three-hasil-tab">
                                            ass
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
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
<script type="text/javascript" src="https://unpkg.com/nprogress@0.2.0/nprogress.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.js"></script>
    <script>

        $(function () {
          $(".datatable").DataTable({
            "autoWidth": true
          });
        });

    </script>
    @if ($persen)
    <script>

        $(document).ready(()=>{
            getTrend().then(() => {console.log('Data Trend')});
        });

        const getTrend = async () => {
            $('.trend').remove();
            let dataLatih = {!! json_encode($dataLatih->toArray()) !!};
            let iteration = 0;
            let logy = 0, xlogy = 0, x2 = 0;
            $.each(dataLatih, (index, value) => {
                let temp, x, y = value.jumlah, a = 0, b = 0;
                let log10y = Math.log10(y);
                temp += `<td>${x = iteration - Math.floor(_.size(dataLatih) / 2)}</td>`;
                temp += `<td>${y != 0 ? x * y : 0}</td>`;
                temp += `<td>${Math.pow(x, 2)}</td>`;
                temp += `<td>${Math.pow(y, 2)}</td>`;
                temp += `<td>${isFinite(log10y) ? a = log10y.toFixed(3) : a = 0}</td>`;
                temp += `<td>${isFinite(log10y) ? b = (x * a).toFixed(3) : b = 0}</td>`;
                x2 += Math.pow(x, 2);
                logy += parseFloat(a);
                xlogy += parseFloat(b);
                iteration++;
                $('#trend-tr-'+iteration).append(temp);
            });
            let a = Math.pow(10, logy / _.size(dataLatih)).toFixed(9);
            let b = Math.pow(10, xlogy / x2).toFixed(9);
            console.log(a, b);

            $('#trend-table').DataTable({
                "autoWidth": true
            });
        }

        var donutChartCanvas = $('#donutChart').get(0).getContext('2d')
        var donutData        = {
        labels: [
            'Data Latih',
            'Data Uji',
        ],
        datasets: [
            {
            data: [{{ $dataLatih->count() }}, {{ $dataUji->count() }}],
            backgroundColor : ['#f39c12', '#00a65a'],
            }
        ]
        }
        var donutOptions     = {
            maintainAspectRatio : false,
            responsive : true,
        }
        //Create pie or douhnut chart
        // You can switch between pie and douhnut using the method below.
        var donutChart = new Chart(donutChartCanvas, {
            type: 'doughnut',
            data: donutData,
            options: donutOptions
        })

    </script>
    @endif
@endpush
