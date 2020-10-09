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
                            <span class="info-box-number">{{number_format($data['latih']->count(),0,'.','.')}} Data</span>

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
                            <span class="info-box-number">{{number_format($data['uji']->count(),0,'.','.')}} Data</span>

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
                            <span class="info-box-number">{{number_format($data['all']->count(),0,'.','.')}} Titik</span>

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
                                            <h4 class="box-title">Jumlah Titik Api</h4>
                                            </div>
                                            <div class="box-body">
                                            <div class="chart">
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
                                            <h4 class="box-title">Akurasi</h4>
                                            </div>
                                            <div class="box-body">
                                            <div class="chart">
                                                <canvas id="lineChart" style="height:250px"></canvas>
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

        $(document).ready( () => {

            const data = {
                //
            }
            $.ajax({
                type: 'POST',
                url: '{{ route('api.home.chart') }}',
                data: data,
                dataType: 'json',
                success: (response) => {
                    console.log(response);
                    chartTitikApi(response.dataset);
                    chartRamalan(response.ramalan);
                },
                error: function(error){
                    console.error(error);
                }
            })

        });

        const chartTitikApi = async (data) => {

            console.log(data);
            var lineChartData = {
                labels: data.labels,
                datasets: [{
                    label: 'Data Aktual',
                    borderColor: color = this.getRandomColor(),
                    backgroundColor: color,
                    fill: false,
                    data: data.jumlah,
                    yAxisID: 'y-axis-1',
                }]
            };

            var ctx = $('#chart-titik-api')[0].getContext('2d');
            window.myLine = Chart.Line(ctx, {
                data: lineChartData,
                options: {
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
                    label: 'Data Aktual',
                    borderColor: color = this.getRandomColor(),
                    backgroundColor: color,
                    fill: false,
                    data: data.jumlah,
                    yAxisID: 'y-axis-1',
                }, {
                    label: 'Ramalan Aditif',
                    borderColor: color = this.getRandomColor(),
                    backgroundColor: color,
                    fill: false,
                    data: data.aditif,
                    yAxisID: 'y-axis-2'
                }, {
                    label: 'Ramalan Multiplikatif',
                    borderColor: color = this.getRandomColor(),
                    backgroundColor: color,
                    fill: false,
                    data: data.multiplikatif,
                    yAxisID: 'y-axis-2'
                }]
            };

			var ctx = $('#lineChart')[0].getContext('2d');
			window.myLine = Chart.Line(ctx, {
				data: lineChartData,
				options: {
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

        function getRandomColor() {
            var letters = '0123456789ABCDEF';
            var color = '#';
            for (var i = 0; i < 6; i++) {
                color += letters[Math.floor(Math.random() * 16)];
            }
            return color;
        }

    </script>
    {{-- <script>
        // bar chart
        let labels = {!! json_encode($year) !!};
        let data = {!! json_encode($jumlah) !!};
        let color = [];
        labels.forEach(x => {
            let tmp = getRandomColor();
            color.push(tmp);
        });
        let datasets = [];
        for (let i = 0; i < labels.length; i++) {
            let tmp = new Object;
            tmp.label = labels[i];
            tmp.data = data[i];
            tmp.backgroundColor = getRandomColor();
            tmp.borderColor = tmp.backgroundColor;
            tmp.borderWidth = 1
            datasets.push(tmp);
        }
        console.log(datasets);

        var ctx = $('#barChart')[0].getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: labels[0],
                    data: data,
                    backgroundColor: color,
                    borderColor: color,
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        stacked: true
                    }]
                }
            }
        });

        // end bar chart

        let waktu = {!! json_encode($waktu) !!};
        labels = {!! json_encode($uji['waktu']) !!};
        data1 = {!! json_encode($uji['jumlah']) !!};
        data2 = {!! json_encode($prediksi['aditif']) !!};
        data3 = {!! json_encode($prediksi['multiplikatif']) !!};
        var lineChartData = {
			labels: labels,
			datasets: [{
				label: 'Data Aktual',
				borderColor: color = this.getRandomColor(),
				backgroundColor: color,
				fill: false,
				data: data1,
				yAxisID: 'y-axis-1',
			}, {
				label: 'Ramalan Aditif',
				borderColor: color = this.getRandomColor(),
				backgroundColor: color,
				fill: false,
				data: data2,
				yAxisID: 'y-axis-2'
			}, {
				label: 'Ramalan Multiplikatif',
				borderColor: color = this.getRandomColor(),
				backgroundColor: color,
				fill: false,
				data: data3,
				yAxisID: 'y-axis-2'
			}]
		};

		window.onload = function() {
			var ctx = $('#lineChart')[0].getContext('2d');
			window.myLine = Chart.Line(ctx, {
				data: lineChartData,
				options: {
					responsive: true,
					hoverMode: 'index',
					stacked: false,
					title: {
						display: true,
						text: waktu
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
		};

        // end line chart
        function getRandomColor() {
            var letters = '0123456789ABCDEF';
            var color = '#';
            for (var i = 0; i < 6; i++) {
                color += letters[Math.floor(Math.random() * 16)];
            }
            return color;
        }
    </script> --}}
@endpush

