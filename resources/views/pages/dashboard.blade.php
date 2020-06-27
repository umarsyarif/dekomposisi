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
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                {{-- <div class="card-body">
                                    <h4 class="text-center">SISTEM PERAMALAN JUMLAH KEMUNCULAN TITIK API DI RIAU</h4>
                                    <h5 class="text-center mb-5">MENGGUNAKAN METODE DEKOMPOSISI</h5>
                                    <p class="card-text">
                                        Lorem ipsum dolor, sit amet consectetur adipisicing elit. Rerum ipsam quia ducimus, explicabo harum amet expedita non. Quis labore iste saepe voluptas, hic voluptatem sapiente, itaque eos, et eaque expedita.
                                        Lorem, ipsum dolor sit amet consectetur adipisicing elit. Expedita consequuntur et doloremque quos! Porro, laboriosam eveniet blanditiis distinctio laborum quam ut. Suscipit quod recusandae eaque voluptatibus itaque praesentium facere similique.
                                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Corporis quisquam suscipit in assumenda inventore nulla id labore unde rerum doloribus, repellendus repellat quibusdam ducimus aliquam voluptates similique dolorum accusamus amet.
                                        Lorem ipsum, dolor sit amet consectetur adipisicing elit. Animi odit sit velit quos qui, expedita sequi iusto aliquid ea perferendis quas, voluptates dolorem eveniet deleniti laborum officia, nulla nesciunt consequuntur?
                                    </p>
                                    <a href="{{route('page', 'data-latih')}}" class="btn btn-primary float-right mt-3">Start</a>
                                </div> --}}
                                <!-- LINE CHART -->
                                <div class="box box-info">
                                    <div class="box-header with-border">
                                    <h3 class="box-title">Jumlah Titik Api</h3>
                                    </div>
                                    <div class="box-body">
                                    <div class="chart">
                                        <canvas id="barChart" style="height:250px"></canvas>
                                    </div>
                                    </div>
                                    <!-- /.box-body -->
                                </div>
                                <div class="box box-info">
                                    <div class="box-header with-border">
                                    <h3 class="box-title">Akurasi</h3>
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
@endsection
@push('scripts')
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.js"></script>
    <script>
        // bar chart
        let labels = {!! json_encode($year) !!};
        let data = {!! json_encode($jumlah) !!};
        let color = [];
        labels.forEach(x => {
            let tmp = getRandomColor();
            color.push(tmp);
        });

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
        data2 = {!! json_encode($prediksi) !!};
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
				label: 'Prediksi',
				borderColor: color = this.getRandomColor(),
				backgroundColor: color,
				fill: false,
				data: data2,
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
    </script>
@endpush

