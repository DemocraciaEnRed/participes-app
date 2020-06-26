<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Partícipes</title>
  <link href="https://fonts.googleapis.com/css?family=Muli:400,400i,600,700" rel="stylesheet">
  <!-- inject:css-->
  <script type="module" src="https://unpkg.com/ionicons@5.0.0/dist/ionicons/ionicons.esm.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <link rel="stylesheet" href="vendor_assets/css/bootstrap/bootstrap.css">
  <link rel="stylesheet" href="vendor_assets/css/brands.css">
  <link rel="stylesheet" href="vendor_assets/css/fontawesome.min.css">
  <link rel="stylesheet" href="vendor_assets/css/jquery-ui.css">
  <link rel="stylesheet" href="vendor_assets/css/jquery.mCustomScrollbar.css">
  <link rel="stylesheet" href="vendor_assets/css/line-awesome.min.css">
  <link rel="stylesheet" href="vendor_assets/css/magnific-popup.css">
  <link rel="stylesheet" href="vendor_assets/css/owl.carousel.min.css">
  <link rel="stylesheet" href="vendor_assets/css/select2.min.css">
  <link rel="stylesheet" href="vendor_assets/css/slick.css">
  <link rel="stylesheet" href="vendor_assets/css/style.css">
  <!-- endinject -->
  <link rel="icon" type="image/png" sizes="32x32" href="img/fevicon.png">
</head>

<body>

  <section class="intro-wrapper bgimage overlay overlay--dark">
    <div class="bg_image_holder"><img src="http://laguiadelocioenparaguay.com/wp-content/uploads/2017/10/rosario2.jpg" alt=""></div>
    <div class="mainmenu-wrapper bg-blue">
      <div class="menu-area  menu--light">
        <div class="top-menu-area">
          <div class="container">
            <div class="row">
              <div class="col-lg-12">
                <div class="menu-fullwidth">
                  <div class="logo-wrapper order-lg-0 order-sm-1">
                    <div class="logo logo-top">
                      <a href="index.php"><img src="img/logo-white.png" alt="logo image" class="img-fluid"></a>
                    </div>
                  </div><!-- ends: .logo-wrapper -->

                  <div class="menu-right order-lg-2 order-sm-2">

                    <!-- start .author-area -->
                    <div class="author-area">
                      <div class="">
                        <ul class="d-flex list-unstyled align-items-center">

                          @guest
                          <li>
                            <a href="{{ route('login') }}" class="btn btn-outline-light ">  {{ __('Login') }}  </a>
                          </li>
                            @if (Route::has('register'))
                            <li>
                              <a href="{{ route('register') }}" class="btn btn-outline-light m-left-20">  {{ __('Register') }}  </a>
                            </li>
                            @endif
                          @else
                          <li class="nav-item dropdown p-top-10">
                                {{ Auth::user()->name }}
                              <div class="dropdown-menu dropdown-menu-right position-absolute p-0" aria-labelledby="navbarDropdown">
                                  <a class="dropdown-item py-2" href="#">
                                      <ion-icon name="person-outline"></ion-icon>
                                      Mi perfil
                                  </a>


                                  <div class="dropdown-divider m-0"></div>

                                  <a class="dropdown-item py-2" href="#" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                      <ion-icon name="log-out-outline"></ion-icon>
                                      Salir
                                  </a>
                                  <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                      @csrf
                                  </form>
                              </div>
                          </li>

                          @endguest

                        </ul>
                      </div>
                    </div>
                    <!-- end .author-area -->

                  </div><!-- ends: .menu-right -->
                </div>
              </div>
            </div>
            <!-- end /.row -->
          </div>
          <!-- end /.container -->
        </div>
        <!-- end  -->
      </div>
    </div><!-- ends: .mainmenu-wrapper -->
    <div class="directory_content_area">
        <div class="container">
          <div class="row">
            <div class="col-lg-6 col-md-6 m-bottom-40">
              <div class="search_title_area text-left">
                <p class="sub_title">Canal de gestión y seguimiento de proyectos, donde podes ver el avance de tus objetivos y metas</p>
                <button type="button" class="btn btn-lg btn-danger m-top-20" id="addNewFAQS">
                  ¿Qué es partícipes?
                </button>
              </div>




            </div>
            <div class="col-lg-6 ">
              <img src="" alt="">
            </div>
          </div>
        </div>




      </div><!-- ends: .directory_search_area -->
  </section><!-- ends: .intro-wrapper -->
