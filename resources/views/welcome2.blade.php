<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>{{config('app.name')}}</title>
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <meta content="" name="keywords">
  <meta content="" name="description">

  <!-- Favicons -->
  <link href="{{asset('DevFolio/img/favicon.png')}}" rel="icon">
  <link href="{{asset('DevFolio/img/apple-touch-icon.png')}}" rel="apple-touch-icon">

  <!-- Bootstrap CSS File -->
  <link href="{{asset('DevFolio/lib/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">

  <!-- Libraries CSS Files -->
  <link href="{{asset('DevFolio/lib/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet">
  <link href="{{asset('DevFolio/lib/animate/animate.min.css')}}" rel="stylesheet">
  <link href="{{asset('DevFolio/lib/ionicons/css/ionicons.min.css')}}" rel="stylesheet">
  <link href="{{asset('DevFolio/lib/owlcarousel/assets/owl.carousel.min.css')}}" rel="stylesheet">
  <link href="{{asset('DevFolio/lib/lightbox/css/lightbox.min.css')}}" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="{{asset('datatables/datatables.min.css')}}"/>
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

  <!-- Main Stylesheet File -->
  <link href="{{asset('DevFolio/css/style.css')}}" rel="stylesheet">

  <!-- =======================================================
    Theme Name: DevFolio
    Theme URL: https://bootstrapmade.com/devfolio-bootstrap-portfolio-html-template/
    Author: BootstrapMade.com
    License: https://bootstrapmade.com/license/
  ======================================================= -->
</head>

<body id="page-top">

  <!--/ Nav Star /-->
  <nav class="navbar navbar-b navbar-trans navbar-expand-md fixed-top" id="mainNav">
    <div class="container">
      <a class="navbar-brand js-scroll" href="#page-top">Forecast</a>
      <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarDefault"
        aria-controls="navbarDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span></span>
        <span></span>
        <span></span>
      </button>
      <div class="navbar-collapse collapse justify-content-end" id="navbarDefault">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link js-scroll active" href="#home">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link js-scroll" href="#about">About</a>
          </li>
          <li class="nav-item">
            <a class="nav-link js-scroll" href="#service">Data</a>
          </li>
          <li class="nav-item">
            <a class="nav-link js-scroll" href="#work">Peramalan</a>
          </li>
          @auth
            <li class="nav-item">
                <a class="nav-link js-scroll" href="{{route('dashboard')}}"><i class="ion-home mr-2"></i>Dashboard</a>
            </li>
          @endauth
          @guest
            <li class="nav-item">
                <a class="nav-link js-scroll" href="#" data-toggle="modal" data-target="#login-modal"><i class="ion-log-in mr-2"></i>Login</a>
            </li>
          @endguest
        </ul>
      </div>
    </div>
  </nav>
  <!--/ Nav End /-->

  <!--/ Intro Skew Star /-->
  <div id="home" class="intro route bg-image" style="background-image: url(DevFolio/img/intro-bg.jpg)">
    <div class="overlay-itro"></div>
    <div class="intro-content display-table">
      <div class="table-cell">
        <div class="container">
          <p class="display-6 color-d">SISTEM PERAMALAN</p>
          <h1 class="intro-title mb-4">JUMLAH KEMUNCULAN TITIK API</h1>
          {{-- <p class="intro-subtitle"><span class="text-slider-items">CEO DevFolio,Web Developer,Web Designer,Frontend Developer,Graphic Designer</span><strong class="text-slider"></strong></p> --}}
          {{-- <p class="pt-3"><a class="btn btn-primary btn js-scroll px-4" href="#about" role="button">Learn More</a></p> --}}
        </div>
      </div>
    </div>
  </div>
  <!--/ Intro Skew End /-->

  <section id="about" class="about-mf sect-pt4 route">
    <div class="container">
      <div class="row">
        <div class="col-sm-12">
          <div class="box-shadow-full">
            <div class="row">
              <div class="col-md-12">
                <div class="about-me pt-4 pt-md-0">
                  <div class="title-box-2">
                    <h5 class="title-left">
                      About
                    </h5>
                  </div>
                  <p class="lead">
                    Kebakaran hutan merupakan suatu keadaan dimana hutan di landa api yang kemudian
                    mengakibatkan rusaknya hutan dan menimbulkan kerugian ekonomis terhadap hasil hutan dan
                    atau nilai lingkungan. Selain faktor curah hujan yang menjadi indikator yang paling utama
                    sebagai pemicu kebakaran di Indonesia, Titik Panas (Hotspot) juga merupakan indikator
                    kebakaran hutan.
                  </p>
                  <p class="lead">
                    Berdasarkan Data yang dikeluarkan oleh BNPB pada tahun 2019, Masalah
                    bencana yang terjadi di Indonesia salah satunya adalah terbakarnya luas lahan. Data KLHK
                    mencatat luas karhutla dari bulan Januri hingga bulan September 2019 yaitu sebesar 857.756 ha.
                    Data BNPB juga mencatat masih terjadi karhutla di sejumlah wilayah Indonesia pada bulan
                    Oktober 2019. Titik panas atau Hotspot teridentifikasi di beberapa provinsi.
                  </p>
                  <p class="lead">
                    Salah satunya pada Provinsi Riau. Berdasarkan masalah yang telah dijelaskan, maka akan dibangun sebuah aplikasi
                    peramalan jumlah kemunculan titik api yang merupakan salah satu proses penanggulangan
                    kebakaran hutan agar berkurangnya bencana kebakaran hutan dan lahan di Indonesia khususnya
                    pada Provinsi Riau. Aplikasi yang akan dibangun menggunakan metode Dekomposisi berbasis
                    web yang akan di implementasikan menggunakan bahasa pemrograman PHP.
                  </p>
                  <p class="lead">
                    Data utama yang
                    akan digunakan yaitu data jumlah titik api di Provinsi Riau pada tahun 2014-2019 dan data uji
                    adalah data tahun 2020 yang diperoleh dari Lembaga Penerbangan Antariksa
                    Nasional (LAPAN). Pengujian dilakukan dengan pengujian black box dan pengujian akurasi
                    sistem menggunakan Mean Absolute Percent Error (MAPE).
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!--/ Section Services Star /-->
  <section id="service" class="services-mf route">
    <div class="container">
      <div class="row">
        <div class="col-sm-12">
          <div class="title-box text-center">
            <h3 class="title-a">
              Data
            </h3>
            <p class="subtitle-a">
                Data utama yang
                akan digunakan yaitu data jumlah titik api di Provinsi Riau pada tahun 2014-2019.
            </p>
            <div class="line-mf"></div>
          </div>
        </div>
      </div>
    </div>
    <div class="section-counter paralax-mf bg-image" style="background-image: url(DevFolio/img/counters-bg.jpg)">
        <div class="overlay-mf"></div>
        <div class="container">
            <div class="row">
                <div class="col-sm-4 col-lg-4">
                    <div class="counter-box counter-box pt-4 pt-md-0">
                    <div class="counter-ico">
                        <span class="ico-circle"><i class="ion-checkmark-round"></i></span>
                    </div>
                    <div class="counter-num">
                        <p class="counter">{{number_format($latih,0,'.','.')}}</p>
                        <span class="counter-text">Jumlah Dataset</span>
                    </div>
                    </div>
                </div>
                <div class="col-sm-4 col-lg-4">
                    <div class="counter-box pt-4 pt-md-0">
                    <div class="counter-ico">
                        <span class="ico-circle"><i class="ion-ios-calendar-outline"></i></span>
                    </div>
                    <div class="counter-num">
                        <p class="counter">{{$tahun}}</p>
                        <span class="counter-text">Tahun Dataset</span>
                    </div>
                    </div>
                </div>
                <div class="col-sm-4 col-lg-4">
                    <div class="counter-box pt-4 pt-md-0">
                    <div class="counter-ico">
                        <span class="ico-circle"><i class="ion-flame"></i></span>
                    </div>
                    <div class="counter-num">
                        <p class="counter">{{number_format($jumlah,0,'.','.')}}</p>
                        <span class="counter-text">Total Ttitik Api</span>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </section>
  <!--/ Section Services End /-->

  <!--/ Section Portfolio Star /-->
  <section id="work" class="portfolio-mf sect-pt4 route pb-5">
    <div class="container">
      <div class="row">
        <div class="col-sm-12">
          <div class="title-box text-center">
            <h3 class="title-a">
              Peramalan
            </h3>
            <p class="subtitle-a">
              Pilih tanggal yang akan di ramal jumlah titik apinya.
            </p>
            <div class="line-mf"></div>
          </div>
        </div>
      </div>
      <div class="col-12 mb-5">
          <div class="card mb-2">
              <div class="card-body">
                  <form action="" method="get" id="ramalan-form">
                      @csrf
                      <div class="modal-body">
                          <div class="form-group">
                              <div class="input-group">
                                  <input type="text" class="form-control" id="datepicker" name="tanggal" placeholder="Pilih tanggal" required>
                                  <div class="input-group-append">
                                      <button type="submit" class="btn btn-primary">Check</button>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </form>
              </div>
          </div>
          <div class="card d-none" id="ramalan-table">
              <div class="card-header">
                    <button type="button" class="btn btn-box-tool float-right" onclick="hide()"><i class="fa fa-times"></i></button>
              </div>
              <div class="card-body">
                  <h4 class="text-center mb-3">Peramalan Jumlah Titik Api</h4>
                  <table id="example1" class="table table-bordered table-striped">
                      <thead>
                          <tr>
                              <th class="text-center" rowspan="2">No</th>
                              <th class="text-center" rowspan="2">Tanggal / Bulan</th>
                              <th class="text-center" rowspan="2">Xt</th>
                              <th class="text-center" colspan="2">Jumlah Titik Api</th>
                          </tr>
                      </thead>
                      <tbody id="peramalan-table-body">
                      </tbody>
                  </table>
              </div>
          </div>
      </div>
    </div>
  </section>
  <!--/ Section Portfolio End /-->

  <!--/ Section Testimonials Star /-->
  <div class="testimonials paralax-mf bg-image" style="background-image: url(DevFolio/img/overlay-bg.jpg)">
    <div class="overlay-mf"></div>
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div id="testimonial-mf" class="owl-carousel owl-theme">
            <div class="testimonial-box">
              <div class="author-test">
                <img src="{{asset('DevFolio/img/testimonial-2.jpg')}}" alt="" class="rounded-circle b-shadow-a">
                <span class="author">UIN SULTAN SYARIF KASIM</span>
              </div>
              <div class="content-test">
                <p class="description lead">
                  Curabitur arcu erat, accumsan id imperdiet et, porttitor at sem. Lorem ipsum dolor sit amet,
                  consectetur adipiscing elit.
                </p>
                <span class="comit"><i class="fa fa-quote-right"></i></span>
              </div>
            </div>
            <div class="testimonial-box">
              <div class="author-test">
                <img src="{{asset('DevFolio/img/dekomposisi.png')}}" alt="" class="rounded-circle b-shadow-a" sizes="200px">
                <span class="author">Dekomposisi</span>
              </div>
              <div class="content-test">
                <p class="description lead">
                  Curabitur arcu erat, accumsan id imperdiet et, porttitor at sem. Lorem ipsum dolor sit amet,
                  consectetur adipiscing elit.
                </p>
                <span class="comit"><i class="fa fa-quote-right"></i></span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

    <!-- Modal Create -->
    <div class="modal fade" id="login-modal" tabindex="-1" role="dialog" aria-labelledby="login-modal-label" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="login-modal-label">Login</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <li>Username atau Password salah!</li>
                        </div>
                    @endif
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-7">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-7">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0 mr-4 float-right">
                            <div class="col-md-8">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Create -->

  <a href="#" class="back-to-top"><i class="fa fa-chevron-up"></i></a>
  <div id="preloader"></div>


  <!-- JavaScript Libraries -->
  <script src="{{asset('DevFolio/lib/jquery/jquery.min.js')}}"></script>
  <script src="{{asset('DevFolio/lib/jquery/jquery-migrate.min.js')}}"></script>
  <script src="{{asset('DevFolio/lib/popper/popper.min.js')}}"></script>
  <script src="{{asset('DevFolio/lib/bootstrap/js/bootstrap.min.js')}}"></script>
  <script src="{{asset('DevFolio/lib/easing/easing.min.js')}}"></script>
  <script src="{{asset('DevFolio/lib/counterup/jquery.waypoints.min.js')}}"></script>
  <script src="{{asset('DevFolio/lib/counterup/jquery.counterup.js')}}"></script>
  <script src="{{asset('DevFolio/lib/owlcarousel/owl.carousel.min.js')}}"></script>
  <script src="{{asset('DevFolio/lib/lightbox/js/lightbox.min.js')}}"></script>
  <script src="{{asset('DevFolio/lib/typed/typed.min.js')}}"></script>
  <!-- Contact Form JavaScript File -->
  <script src="{{asset('DevFolio/contactform/contactform.js')}}"></script>
  {{-- Datarange Picker --}}
  <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
  {{-- Datatables --}}
  <script type="text/javascript" src="{{asset('datatables/datatables.min.js')}}"></script>
  <!-- Template Main Javascript File -->
  <script src="{{asset('DevFolio/js/main.js')}}"></script>

  <script>
        // $("#example1").DataTable({
        //     "autoWidth": true
        // });

        $("#datepicker").daterangepicker({
            locale: {
                format: 'DD/MM/YYYY'
            },
            opens: 'left'
        }, function(start, end, label){
            val = start.format('DD/MM/YYYY')+' - '+end.format('DD/MM/YYYY');
        });


        let val = $('#datepicker').val();
        $("#ramalan-form").submit((e) => {
            let data = {
                tanggal: val
            }
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: '/api/peramalan',
                data: data,
                dataType: 'json',
                success: (response) => {
                    $('#ramalan-table').removeClass('d-none');
                    $('#peramalan-table-body').empty();
                    let xt = response.data.xt;
                    let uji = response.data.uji;
                    let a = response.data.a;
                    let b = response.data.b;
                    let no = 1;
                    let print = uji.map(x => {
                        const date = new Date(x.waktu.date).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });
                        let tmp = '<tr>';
                        tmp += '<td>'+no+'</td>';
                        tmp += `<td class="text-center">${date}</td>`;
                        tmp += '<td class="text-center">'+xt+'</td>';
                        tmp += '<td class="text-center">'+Math.round((a * Math.pow(b, xt)) + x.musiman)+'</td>';
                        tmp += '</tr>'
                        no++;
                        xt++;
                        return tmp;
                    });
                    $('#peramalan-table-body').append(print);
                },
                error: function(error){
                    console.error(error);
                }
            })
        });

        function hide(){
            $('#ramalan-table').addClass('d-none');
        }
  </script>
  @if ($errors->any())
    <script>
        $('#login-modal').modal('show');
    </script>
  @endif

</body>
</html>
