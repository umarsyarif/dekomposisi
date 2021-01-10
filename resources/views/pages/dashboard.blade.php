<?php
$title = 'Dashboard';
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
                    <div class="col-md-4">
                        <!-- Info Boxes Style 2 -->
                        <div class="info-box">
                            <span class="info-box-icon bg-primary"><i class="fas fa-chart-bar"></i></span>

                            <div class="info-box-content">
                            <span class="info-box-text">Total Data Latih</span>
                            <span class="info-box-number">{{number_format($data['latih'],0,'.','.')}} Data</span>

                            <div class="progress">
                                <div class="progress-bar" style="width: 0%"></div>
                            </div>
                            <span class="progress-description">
                                    Tahun {{$year->first()->year .'-'. $year[count($year)-2]->year}}
                                </span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <div class="col-md-4">
                        <!-- Info Boxes Style 2 -->
                        <div class="info-box">
                            <span class="info-box-icon bg-success"><i class="fas fa-chart-area"></i></span>

                            <div class="info-box-content">
                            <span class="info-box-text">Total Data uji</span>
                            <span class="info-box-number">{{number_format($data['uji'],0,'.','.')}} Data</span>

                            <div class="progress">
                                <div class="progress-bar" style="width: 0%"></div>
                            </div>
                            <span class="progress-description">
                                    Tahun {{$year->last()->year}}
                                </span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <div class="col-md-4">
                        <!-- Info Boxes Style 2 -->
                        <div class="info-box">
                            <span class="info-box-icon bg-red"><i class="fas fa-fire"></i></span>

                            <div class="info-box-content">
                            <span class="info-box-text">Total Titik Api</span>
                            <span class="info-box-number">{{number_format($data['all'],0,'.','.')}} Titik</span>

                            <div class="progress">
                                <div class="progress-bar" style="width: 0%"></div>
                            </div>
                            <span class="progress-description">
                                    Tahun {{$year->first()->year .'-'. $year->last()->year}}
                                </span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-6">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="box box-info">
                                            <div class="box-header with-border">
                                                <h4 class="box-title">Dataset</h4>
                                            </div>
                                            <div class="box-body">
                                            <div class="chart" id="chart-container">
                                                <canvas id="chart-titik-api" style="height:250px"></canvas>
                                            </div>
                                            </div>
                                            <!-- /.box-body -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="box box-info">
                                            <div class="box-header with-border">
                                                <h4 class="box-title">Data Latih</h4>
                                            </div>
                                            <div class="box-body">
                                                <div class="row">
                                                    <div class="col-1 pt-2">
                                                        <a href="javascript:void(0);" id="prevBtn">
                                                            <i class="fas fa-chevron-left"></i>
                                                        </a>
                                                    </div>
                                                    <div class="chart col-10 px-0" id="lineChart-container">
                                                        <canvas id="lineChart" style="height:250px"></canvas>
                                                    </div>
                                                    <div class="col-1 pt-2">
                                                        <a href="javascript:void(0);" id="nextBtn">
                                                            <i class="fas fa-chevron-right"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- /.box-body -->
                                        </div>
                                    </div>
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
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.js"></script>
    <script>

        var allTahun = [2014, 2015, 2016, 2017, 2018];
        var tahun = null;
        $(document).ready( () => {
            var data = {}
            dataset();
            request(data);

            $('#nextBtn').click(function() {
                console.log(parseInt(tahun) + 1);
                if (allTahun.indexOf(tahun + 1) > -1) {
                    var data = {
                        tahun : tahun + 1
                    }
                    resetCanvas('lineChart');
                    request(data);
                }
                return;
            });

            $('#prevBtn').click(function() {
                if (allTahun.indexOf(tahun - 1) > -1) {
                    var data = {
                        tahun : tahun - 1
                    }
                    resetCanvas('lineChart');
                    request(data);
                }
                return;
            });
        });

        function dataset(){
            $.ajax({
                type: 'POST',
                url: '{{ route('api.home.chart') }}',
                data: {},
                dataType: 'json',
                success: (response) => {
                    chartTitikApi(response.dataset);
                },
                error: function(error){
                    console.error(error);
                }
            });
        }

        function request(data) {
            $.ajax({
                type: 'POST',
                url: '{{ route('api.home.chart') }}',
                data: data,
                dataType: 'json',
                success: (response) => {
                    chartRamalan(response.kecamatan);
                    tahun = parseInt(response.kecamatan.judul);
                    console.log(tahun);
                },
                error: function(error){
                    console.error(error);
                }
            });
        }

        const chartTitikApi = async (data) => {
            var lineChartData = {
                labels: data.labels,
                datasets: [{
                    label: 'Jumlah Titik Api',
                    borderColor: color = this.getRandomColor(),
                    backgroundColor: color,
                    fill: false,
                    data: data.jumlah,
                    yAxisID: 'y-axis-1',
                }]
            };

            var ctx = $('#chart-titik-api')[0].getContext('2d');
            window.myLine = Chart.Bar(ctx, {
                data: lineChartData,
                options: {
                    maintainAspectRatio: false,
                    responsive: true,
                    hoverMode: 'index',
                    stacked: false,
                    title: {
                        display: true,
                        text: data.judul
                    },
                    scales: {
                        yAxes: [{
                            type: 'linear', // only linear but allow scale type registration. This allows extensions to exist solely for log scale for instance
                            display: true,
                            position: 'left',
                            id: 'y-axis-1',
                        }, {
                            type: 'linear', // only linear but allow scale type registration. This allows extensions to exist solely for log scale for instance
                            display: true,
                            position: 'right',
                            id: 'y-axis-2',

                            // grid line settings
                            gridLines: {
                                drawOnChartArea: false, // only want the grid lines for one axis to show up
                            },
                        }],
                    }
                }
            });
        }

        const chartRamalan = async (data) => {
            var lineChartData = {
                labels: data.labels,
                datasets: [{
                    label: '',
                    borderColor: color = this.getRandomColor(),
                    backgroundColor: color,
                    fill: false,
                    data: data.jumlah,
                    yAxisID: 'y-axis-1',
                }]
            };

            var ctx = $('#lineChart')[0].getContext('2d');
            window.myLine = Chart.Bar(ctx, {
                data: lineChartData,
                options: {
                    maintainAspectRatio: false,
                    responsive: true,
                    hoverMode: 'index',
                    stacked: false,
                    title: {
                        display: true,
                        text: data.judul
                    },
                    scales: {
                        yAxes: [{
                            type: 'linear', // only linear but allow scale type registration. This allows extensions to exist solely for log scale for instance
                            display: true,
                            position: 'left',
                            id: 'y-axis-1',
                        }, {
                            type: 'linear', // only linear but allow scale type registration. This allows extensions to exist solely for log scale for instance
                            display: true,
                            position: 'right',
                            id: 'y-axis-2',

                            // grid line settings
                            gridLines: {
                                drawOnChartArea: false, // only want the grid lines for one axis to show up
                            },
                        }],
                    }
                }
            });
        }

        function resetCanvas(name) {
            $(`#${name}`).remove();
            $(`#${name}-container`).append(`<canvas id="${name}" style="height:250px"></canvas>`);
        }

        function getRandomColor() {
            var letters = '0123456789ABCDEF';
            var color = '#';
            for (var i = 0; i < 6; i++) {
                color += letters[Math.floor(Math.random() * 16)];
            }
            return color;
        }

        function getRamalan(data) {
            var aditif = data.uji.map(x => {
                return (Math.round((data.a * Math.pow(data.b, data.xt)) + x.musiman))
            })
            var multiplikatif = data.uji.map(x => {
                return (Math.round((data.a * Math.pow(data.b, data.xt)) * x.musiman))
            })
            return {aditif: aditif, multiplikatif: multiplikatif};
        }

    </script>
@endpush

