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
            <a class="nav-link js-scroll" href="#service">Features</a>
          </li>
          <li class="nav-item">
            <a class="nav-link js-scroll" href="#work">Peramalan</a>
          </li>
          <li class="nav-item">
            <a class="nav-link js-scroll" href="#blog">Blog</a>
          </li>
          <li class="nav-item">
            <a class="nav-link js-scroll" href="#contact">Contact</a>
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
              {{-- <div class="col-md-6">
                <div class="row">
                  <div class="col-sm-6 col-md-5">
                    <div class="about-img">
                      <img src="{{asset('DevFolio/img/testimonial-2.jpg')}}" class="img-fluid rounded b-shadow-a" alt="">
                    </div>
                  </div>
                  <div class="col-sm-6 col-md-7">
                    <div class="about-info">
                      <p><span class="title-s">Name: </span> <span>Morgan Freeman</span></p>
                      <p><span class="title-s">Profile: </span> <span>full stack developer</span></p>
                      <p><span class="title-s">Email: </span> <span>contact@example.com</span></p>
                      <p><span class="title-s">Phone: </span> <span>(617) 557-0089</span></p>
                    </div>
                  </div>
                </div>
                <div class="skill-mf">
                  <p class="title-s">Skill</p>
                  <span>HTML</span> <span class="pull-right">85%</span>
                  <div class="progress">
                    <div class="progress-bar" role="progressbar" style="width: 85%;" aria-valuenow="85" aria-valuemin="0"
                      aria-valuemax="100"></div>
                  </div>
                  <span>CSS3</span> <span class="pull-right">75%</span>
                  <div class="progress">
                    <div class="progress-bar" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0"
                      aria-valuemax="100"></div>
                  </div>
                  <span>PHP</span> <span class="pull-right">50%</span>
                  <div class="progress">
                    <div class="progress-bar" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0"
                      aria-valuemax="100"></div>
                  </div>
                  <span>JAVASCRIPT</span> <span class="pull-right">90%</span>
                  <div class="progress">
                    <div class="progress-bar" role="progressbar" style="width: 90%" aria-valuenow="90" aria-valuemin="0"
                      aria-valuemax="100"></div>
                  </div>
                </div>
              </div> --}}
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
                    Data latih yang
                    akan digunakan yaitu data jumlah titik api di Provinsi Riau pada tahun 2014-2019 dan data uji
                    adalah data bulan Januari tahun 2020 yang diperoleh dari Lembaga Penerbangan Antariksa
                    Nasional (LAPAN). Pengujian dilakukan dengan pengujian black box dan pengujian akurasi
                    sistem menggunakan Mean Absolute Percent Error (MAPE).
                  </p>
                  {{-- <p class="lead">
                    Curabitur non nulla sit amet nisl tempus convallis quis ac lectus. Curabitur arcu erat, accumsan id
                    imperdiet et, porttitor
                    at sem. Praesent sapien massa, convallis a pellentesque nec, egestas non nisi. Nulla
                    porttitor accumsan tincidunt.
                  </p>
                  <p class="lead">
                    Mauris blandit aliquet elit, eget tincidunt nibh pulvinar a. Vivamus suscipit tortor eget felis
                    porttitor volutpat. Vestibulum
                    ac diam sit amet quam vehicula elementum sed sit amet dui. porttitor at sem.
                  </p>
                  <p class="lead">
                    Nulla porttitor accumsan tincidunt. Quisque velit nisi, pretium ut lacinia in, elementum id enim.
                    Nulla porttitor accumsan
                    tincidunt. Mauris blandit aliquet elit, eget tincidunt nibh pulvinar a.
                  </p> --}}
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
              Features
            </h3>
            <p class="subtitle-a">
              Lorem ipsum, dolor sit amet consectetur adipisicing elit.
            </p>
            <div class="line-mf"></div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-4">
          <div class="service-box">
            <div class="service-ico">
              <span class="ico-circle"><i class="ion-monitor"></i></span>
            </div>
            <div class="service-content">
              <h2 class="s-title">Web Design</h2>
              <p class="s-description text-center">
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Magni adipisci eaque autem fugiat! Quia,
                provident vitae! Magni
                tempora perferendis eum non provident.
              </p>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="service-box">
            <div class="service-ico">
              <span class="ico-circle"><i class="ion-code-working"></i></span>
            </div>
            <div class="service-content">
              <h2 class="s-title">Web Development</h2>
              <p class="s-description text-center">
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Magni adipisci eaque autem fugiat! Quia,
                provident vitae! Magni
                tempora perferendis eum non provident.
              </p>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="service-box">
            <div class="service-ico">
              <span class="ico-circle"><i class="ion-camera"></i></span>
            </div>
            <div class="service-content">
              <h2 class="s-title">Photography</h2>
              <p class="s-description text-center">
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Magni adipisci eaque autem fugiat! Quia,
                provident vitae! Magni
                tempora perferendis eum non provident.
              </p>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="service-box">
            <div class="service-ico">
              <span class="ico-circle"><i class="ion-android-phone-portrait"></i></span>
            </div>
            <div class="service-content">
              <h2 class="s-title">Responsive Design</h2>
              <p class="s-description text-center">
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Magni adipisci eaque autem fugiat! Quia,
                provident vitae! Magni
                tempora perferendis eum non provident.
              </p>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="service-box">
            <div class="service-ico">
              <span class="ico-circle"><i class="ion-paintbrush"></i></span>
            </div>
            <div class="service-content">
              <h2 class="s-title">Graphic Design</h2>
              <p class="s-description text-center">
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Magni adipisci eaque autem fugiat! Quia,
                provident vitae! Magni
                tempora perferendis eum non provident.
              </p>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="service-box">
            <div class="service-ico">
              <span class="ico-circle"><i class="ion-stats-bars"></i></span>
            </div>
            <div class="service-content">
              <h2 class="s-title">Marketing Services</h2>
              <p class="s-description text-center">
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Magni adipisci eaque autem fugiat! Quia,
                provident vitae! Magni
                tempora perferendis eum non provident.
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!--/ Section Services End /-->

  <div class="section-counter paralax-mf bg-image" style="background-image: url(DevFolio/img/counters-bg.jpg)">
    <div class="overlay-mf"></div>
    <div class="container">
      <div class="row">
        <div class="col-sm-3 col-lg-3">
          <div class="counter-box counter-box pt-4 pt-md-0">
            <div class="counter-ico">
              <span class="ico-circle"><i class="ion-checkmark-round"></i></span>
            </div>
            <div class="counter-num">
              <p class="counter">450</p>
              <span class="counter-text">WORKS COMPLETED</span>
            </div>
          </div>
        </div>
        <div class="col-sm-3 col-lg-3">
          <div class="counter-box pt-4 pt-md-0">
            <div class="counter-ico">
              <span class="ico-circle"><i class="ion-ios-calendar-outline"></i></span>
            </div>
            <div class="counter-num">
              <p class="counter">15</p>
              <span class="counter-text">YEARS OF EXPERIENCE</span>
            </div>
          </div>
        </div>
        <div class="col-sm-3 col-lg-3">
          <div class="counter-box pt-4 pt-md-0">
            <div class="counter-ico">
              <span class="ico-circle"><i class="ion-ios-people"></i></span>
            </div>
            <div class="counter-num">
              <p class="counter">550</p>
              <span class="counter-text">TOTAL CLIENTS</span>
            </div>
          </div>
        </div>
        <div class="col-sm-3 col-lg-3">
          <div class="counter-box pt-4 pt-md-0">
            <div class="counter-ico">
              <span class="ico-circle"><i class="ion-ribbon-a"></i></span>
            </div>
            <div class="counter-num">
              <p class="counter">36</p>
              <span class="counter-text">AWARD WON</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

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
                              {{-- <label for="datepicker">Tanggal</label> --}}
                              <div class="input-group">
                                  <input type="text" class="form-control" id="datepicker" name="tanggal" placeholder="Pilih tanggal" required>
                                  <div class="input-group-append">
                                      <button type="submit" class="btn btn-primary">Check</button>
                                  </div>
                              </div>
                              {{-- <small class="text-muted">tanggal yang akan di ramal jumlah titik api nya</small> --}}
                          </div>
                      </div>
                  </form>
              </div>
          </div>
          <div class="card" id="ramalan-table">
              <div class="card-body">
                  <table id="example1" class="table table-bordered table-striped">
                      <thead>
                          <tr>
                              <th class="text-center" rowspan="2">No</th>
                              <th class="text-center" rowspan="2">Tanggal / Bulan</th>
                              <th class="text-center" rowspan="2">Xt</th>
                              <th class="text-center" colspan="2">Peramalan Jumlah Titik Api</th>
                          </tr>
                          <tr>
                              <td class="text-center">Dekomposisi Aditif</td>
                              <td class="text-center">Dekomposisi Multiplikatif</td>
                          </tr>
                      </thead>
                      <?php $jumlahAditif = 0; $jumlahMultiplikatif = 0; ?>
                      <tbody id="peramalan-table-body">
                          {{-- @foreach ($uji as $row) --}}
                          {{-- <tr> --}}
                              {{-- <td></td> --}}
                              {{-- <td></td> --}}
                              {{-- <td></td> --}}
                              {{-- <td></td> --}}
                              {{-- <td></td> --}}
                              {{-- <td class="text-center">{{$loop->iteration}}</td> --}}
                              {{-- <td class="text-center">{{$row->waktu->format('d F Y')}}</td> --}}
                              {{-- <td class="text-center">{{$xt++}}</td> --}}
                              {{-- <?php $aditif = ($a + pow($b, $xt)) + $row->musiman ?> --}}
                              {{-- <td class="text-center">{{round($aditif)}}</td> --}}
                              {{-- <?php $multiplikatif = ($a + pow($b, $xt)) * $row->musiman ?> --}}
                              {{-- <td class="text-center">{{round($multiplikatif)}}</td> --}}
                          {{-- </tr> --}}
                          <?php
                              // $jumlahAditif += $aditif;
                              // $jumlahMultiplikatif += $multiplikatif;
                          ?>
                          {{-- @endforeach --}}
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
                <span class="author">Xavi Alonso</span>
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
                <img src="{{asset('DevFolio/img/testimonial-4.jpg')}}" alt="" class="rounded-circle b-shadow-a">
                <span class="author">Marta Socrate</span>
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

  <!--/ Section Blog Star /-->
  <section id="blog" class="blog-mf sect-pt4 route">
    <div class="container">
      <div class="row">
        <div class="col-sm-12">
          <div class="title-box text-center">
            <h3 class="title-a">
              Blog
            </h3>
            <p class="subtitle-a">
              Lorem ipsum, dolor sit amet consectetur adipisicing elit.
            </p>
            <div class="line-mf"></div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-4">
          <div class="card card-blog">
            <div class="card-img">
              <a href="blog-single.html"><img src="{{asset('DevFolio/img/post-1.jpg')}}" alt="" class="img-fluid"></a>
            </div>
            <div class="card-body">
              <div class="card-category-box">
                <div class="card-category">
                  <h6 class="category">Travel</h6>
                </div>
              </div>
              <h3 class="card-title"><a href="blog-single.html">See more ideas about Travel</a></h3>
              <p class="card-description">
                Proin eget tortor risus. Pellentesque in ipsum id orci porta dapibus. Praesent sapien massa, convallis
                a pellentesque nec,
                egestas non nisi.
              </p>
            </div>
            <div class="card-footer">
              <div class="post-author">
                <a href="#">
                  <img src="{{asset('DevFolio/img/testimonial-2.jpg')}}" alt="" class="avatar rounded-circle">
                  <span class="author">Morgan Freeman</span>
                </a>
              </div>
              <div class="post-date">
                <span class="ion-ios-clock-outline"></span> 10 min
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card card-blog">
            <div class="card-img">
              <a href="blog-single.html"><img src="{{asset('DevFolio/img/post-2.jpg')}}" alt="" class="img-fluid"></a>
            </div>
            <div class="card-body">
              <div class="card-category-box">
                <div class="card-category">
                  <h6 class="category">Web Design</h6>
                </div>
              </div>
              <h3 class="card-title"><a href="blog-single.html">See more ideas about Travel</a></h3>
              <p class="card-description">
                Proin eget tortor risus. Pellentesque in ipsum id orci porta dapibus. Praesent sapien massa, convallis
                a pellentesque nec,
                egestas non nisi.
              </p>
            </div>
            <div class="card-footer">
              <div class="post-author">
                <a href="#">
                  <img src="{{asset('DevFolio/img/testimonial-2.jpg')}}" alt="" class="avatar rounded-circle">
                  <span class="author">Morgan Freeman</span>
                </a>
              </div>
              <div class="post-date">
                <span class="ion-ios-clock-outline"></span> 10 min
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card card-blog">
            <div class="card-img">
              <a href="blog-single.html"><img src="{{asset('DevFolio/img/post-3.jpg')}}" alt="" class="img-fluid"></a>
            </div>
            <div class="card-body">
              <div class="card-category-box">
                <div class="card-category">
                  <h6 class="category">Web Design</h6>
                </div>
              </div>
              <h3 class="card-title"><a href="blog-single.html">See more ideas about Travel</a></h3>
              <p class="card-description">
                Proin eget tortor risus. Pellentesque in ipsum id orci porta dapibus. Praesent sapien massa, convallis
                a pellentesque nec,
                egestas non nisi.
              </p>
            </div>
            <div class="card-footer">
              <div class="post-author">
                <a href="#">
                  <img src="{{asset('DevFolio/img/testimonial-2.jpg')}}" alt="" class="avatar rounded-circle">
                  <span class="author">Morgan Freeman</span>
                </a>
              </div>
              <div class="post-date">
                <span class="ion-ios-clock-outline"></span> 10 min
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!--/ Section Blog End /-->

  <!--/ Section Contact-Footer Star /-->
  {{-- <section class="paralax-mf footer-paralax bg-image sect-mt4 route" style="background-image: url(DevFolio/img/overlay-bg.jpg)">
    <div class="overlay-mf"></div>
    <div class="container">
      <div class="row">
        <div class="col-sm-12">
          <div class="contact-mf">
            <div id="contact" class="box-shadow-full">
              <div class="row">
                <div class="col-md-6">
                  <div class="title-box-2">
                    <h5 class="title-left">
                      Send Message Us
                    </h5>
                  </div>
                  <div>
                      <form action="" method="post" role="form" class="contactForm">
                      <div id="sendmessage">Your message has been sent. Thank you!</div>
                      <div id="errormessage"></div>
                      <div class="row">
                        <div class="col-md-12 mb-3">
                          <div class="form-group">
                            <input type="text" name="name" class="form-control" id="name" placeholder="Your Name" data-rule="minlen:4" data-msg="Please enter at least 4 chars" />
                            <div class="validation"></div>
                          </div>
                        </div>
                        <div class="col-md-12 mb-3">
                          <div class="form-group">
                            <input type="email" class="form-control" name="email" id="email" placeholder="Your Email" data-rule="email" data-msg="Please enter a valid email" />
                            <div class="validation"></div>
                          </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <div class="form-group">
                              <input type="text" class="form-control" name="subject" id="subject" placeholder="Subject" data-rule="minlen:4" data-msg="Please enter at least 8 chars of subject" />
                              <div class="validation"></div>
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                          <div class="form-group">
                            <textarea class="form-control" name="message" rows="5" data-rule="required" data-msg="Please write something for us" placeholder="Message"></textarea>
                            <div class="validation"></div>
                          </div>
                        </div>
                        <div class="col-md-12">
                          <button type="submit" class="button button-a button-big button-rouded">Send Message</button>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="title-box-2 pt-4 pt-md-0">
                    <h5 class="title-left">
                      Get in Touch
                    </h5>
                  </div>
                  <div class="more-info">
                    <p class="lead">
                      Lorem ipsum dolor sit amet consectetur adipisicing elit. Facilis dolorum dolorem soluta quidem
                      expedita aperiam aliquid at.
                      Totam magni ipsum suscipit amet? Autem nemo esse laboriosam ratione nobis
                      mollitia inventore?
                    </p>
                    <ul class="list-ico">
                      <li><span class="ion-ios-location"></span> 329 WASHINGTON ST BOSTON, MA 02108</li>
                      <li><span class="ion-ios-telephone"></span> (617) 557-0089</li>
                      <li><span class="ion-email"></span> contact@example.com</li>
                    </ul>
                  </div>
                  <div class="socials">
                    <ul>
                      <li><a href=""><span class="ico-circle"><i class="ion-social-facebook"></i></span></a></li>
                      <li><a href=""><span class="ico-circle"><i class="ion-social-instagram"></i></span></a></li>
                      <li><a href=""><span class="ico-circle"><i class="ion-social-twitter"></i></span></a></li>
                      <li><a href=""><span class="ico-circle"><i class="ion-social-pinterest"></i></span></a></li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <footer>
      <div class="container">
        <div class="row">
          <div class="col-sm-12">
            <div class="copyright-box">
              <p class="copyright">&copy; Copyright <strong>DevFolio</strong>. All Rights Reserved</p>
              <div class="credits">
                <!--
                  All the links in the footer should remain intact.
                  You can delete the links only if you purchased the pro version.
                  Licensing information: https://bootstrapmade.com/license/
                  Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/buy/?theme=DevFolio
                -->
                Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </footer>
  </section> --}}
  <!--/ Section Contact-footer End /-->

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

                                {{-- @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif --}}
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
            opens: 'left'
        }, function(start, end, label){
            val = start.format('MM/DD/YYYY')+'-'+end.format('MM/DD/YYYY');
        });

        let val = $('#datepicker').val();

        $("#ramalan-form").submit(function(e){
            let data = {
                tanggal: val
            }
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: '/api/prediksi',
                data: data,
                dataType: 'json',
                success: (response) => {
                    $('#peramalan-table-body').empty();
                    let xt = response.xt;
                    let uji = response.uji;
                    let a = response.a;
                    let b = response.b;
                    console.log(data.xt);
                    let no = 1;
                    let print = uji.map(x => {
                        let tmp = '<tr>';
                        tmp += '<td>'+no+'</td>';
                        tmp += '<td class="text-center">'+x.waktu+'</td>';
                        tmp += '<td class="text-center">'+xt+'</td>';
                        tmp += '<td class="text-center">'+Math.round((a + Math.pow(b, xt)) + x.musiman)+'</td>';
                        tmp += '<td class="text-center">'+Math.round((a + Math.pow(b, xt)) * x.musiman)+'</td>';
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
            // var result = $('<tr><td></td><td></td><td></td><td></td><td></td></tr>');
        });
  </script>
  @if ($errors->any())
    <script>
        $('#login-modal').modal('show');
    </script>
  @endif

</body>
</html>
