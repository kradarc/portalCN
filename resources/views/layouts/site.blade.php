<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Corporación del Deporte Cerro Navia')</title>

    <meta property="og:image" content="@yield('og-image', url('/images/Logo_Deporte-17.png'))" />
    <meta property="og:title" content="@yield('og-title', 'Corporación del Deporte Cerro Navia')" />


    <link href="https://fonts.googleapis.com/css?family=Merriweather+Sans:300,300i,400,400i,700,700i,800,800i" rel="stylesheet">
    <link rel="stylesheet" href="{{ elixir('css/site.css') }}">
    
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-115077435-1"></script>
    <script async src='https://www.google-analytics.com/analytics.js'></script>
    <script>
     window.dataLayer = window.dataLayer || [];
     function gtag(){dataLayer.push(arguments);}
     gtag('js', new Date());

     gtag('config', 'UA-115077435-1');
    </script>
    <!-- End Google Analytics -->

    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-P6D82V6');</script>
    <!-- End Google Tag Manager -->


    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-P6D82V6"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    @section('title',  'inicio' )
</head>
<body>
    <div id="app">

      <div id="mySidenav" class="sidenav visible-xs" >
        @if(Auth::user())
            <a href="{{ url('/dashboard') }}" class="left-input"><i class="fa fa-user-o" aria-hidden="true"></i>Administrador</a>
            @else
           <a href="{{ route('login') }}" class="left-input"><i class="fa fa-user-o" aria-hidden="true"></i>Ingresa aquí</a>
        @endif
        
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()"><i class="fa fa-times" aria-hidden="true"></i></a>
        <div class="space-menu">
          <a href="{{ url('/') }}">
            <img src="{{url('/images/Logo_Deporte-17.png')}}" >
          </a>
        </div>
        <div class="buttons">
          <a href="{{ url('/nosotros') }}">Nosotros <span><i class="fa fa-plus-circle" aria-hidden="true"></i></span></a>
          <a href="{{ url('/categorias') }}">Disciplinas <span><i class="fa fa-plus-circle" aria-hidden="true"></i></span></a>
          <a href="{{ url('publicaciones/eventos') }}">Evento <span><i class="fa fa-plus-circle" aria-hidden="true"></i></span></a>
          <a href="{{ url('publicaciones/tercer-tiempo') }}">Tercer Tiempo <span><i class="fa fa-plus-circle" aria-hidden="true"></i></span></a>
          <a href="{{ url('/contacto') }}">Contacto <span><i class="fa fa-plus-circle" aria-hidden="true"></i></span></a>
            @if(!Auth::user())
                <a href="{{ route('register') }}">Inscríbete ahora <span><i class="fa fa-plus-circle" aria-hidden="true"></i></span></a>
                @else
            @endif

          
        </div>
      </div>

       
      <div id="main"> 
        <!-- Use any element to open the sidenav -->
        <div class="fixed-menu visible-xs navbar-fixed-top">
            <div class="container order-nav">
                <div class="icon-menu" onclick="openNav()">
                  <div class="bar1"></div>
                  <div class="bar2"></div>
                  <div class="bar3"></div>
                </div>
                <div class="icon-corporative"> 
                  <a href="{{ url('/') }}">
                    <img src="{{url('/images/Logo_Deporte-17.png')}}" class="img-responsive" >   
                  </a>
                </div>
            </div>
        </div>
        <nav class="navbar navbar-default navbar-fixed-top  nav-default hidden-xs">
          <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
              <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
              <a class="navbar-brand img-responsive" href="{{ url('/') }}">
                <img src="{{url('/images/Logo_Deporte-17.png')}}" >
              </a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse nav-desktop" id="bs-example-navbar-collapse-1">
             
 
              <ul class="nav navbar-nav navbar-right">
                <li class="active"><a href="{{ url('/') }}">Inicio</a></li>
                <li><a href="{{ url('/nosotros') }}">Nosotros </a></li>
                <li><a href="{{ url('/categorias') }}">Disciplinas </a></li>
                <li><a href="{{ url('publicaciones/eventos') }}">Eventos </a></li>
                <li><a href="{{ url('publicaciones/tercer-tiempo') }}">Tercer Tiempo </a></li>
                <li> <a href="{{ url('/contacto') }}">Contacto </a></li>
                

                @if(!Auth::user())
                    <li class="registrate"><a href="{{ route('register') }}">Regístrate </a></li>
                    <li><a href="{{ route('login') }}">Ingresar </a></li>
                    @else
                    <li><a href="{{ route('register') }}" >Portal </a></li>
                @endif


              </ul>
            </div><!-- /.navbar-collapse -->
          </div><!-- /.container-fluid -->
        </nav>
            @yield('content')

      </div>  

    </div>
    
    <footer class="hidden-xs">
        <div class="container">
            <div class="col-md-2 col-xs-2">
                <img src="{{url('/images/logo-blanco-cndeportes.png')}}" class="img-responsive">
            </div>

            <div class="col-md-8 text-fot col-xs-8">
                <p>Llámanos al (+562) 26676631 o contáctanos en contacto@deportescerronavia.cl <br>
                    Mapocho Norte 8115, Cerro Navia, Santiago </p>

            </div>

            <div class="col-md-2 col-xs-2">
                <a href="http://www.cerronavia.cl/">
                <img src="{{url('/images/logocerronavia-footer.png')}}" class="img-responsive">
                </a>
            </div>
        </div>
    </footer>
    
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>

    <script type="text/javascript">

    function openNav() {
        document.getElementById("mySidenav").classList.add('margin-nav');
        document.getElementById("main").classList.add('margin-nav');
        document.body.style.backgroundColor = "rgba(0,0,0,0.4)";
    }

    /* Set the width of the side navigation to 0 and the left margin of the page content to 0, and the background color of body to white */
    function closeNav() {
        document.getElementById("mySidenav").classList.remove('margin-nav');
        document.getElementById("main").classList.remove('margin-nav');
        document.body.style.backgroundColor = "white";
    }

    </script>
    <!--  sliders -->
    @yield('slider-owl')
    <!-- selector multiple -->
    @yield('inputHasContent')

    @yield('facebook')
</body>
</html>
