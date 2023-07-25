<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Shoppers &mdash; Colorlib e-Commerce Template</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Mukta:300,400,700">
    <link rel="stylesheet" href="{{asset('/')}}fonts/icomoon/style.css">

    <link rel="stylesheet" href="{{asset('/')}}css/bootstrap.min.css">
    <link rel="stylesheet" href="{{asset('/')}}css/magnific-popup.css">
    <link rel="stylesheet" href="{{asset('/')}}css/jquery-ui.css">
    <link rel="stylesheet" href="{{asset('/')}}css/owl.carousel.min.css">
    <link rel="stylesheet" href="{{asset('/')}}css/owl.theme.default.min.css">


    <link rel="stylesheet" href="{{asset('/')}}css/aos.css">

    <link rel="stylesheet" href="{{asset('/')}}css/style.css">
    <link rel="stylesheet" href="{{asset('backend/css/alertify.min.css')}}">
    <link rel="icon" href="{{asset('/images/favicon.png')}}" type="image/png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css">
  </head>
  <body>

  <div class="site-wrap">
    {{-- header  --}}
    @include('frontend.inc.header')
    {{-- header  --}}

    {{-- content  --}}
    @yield('content')
    {{-- content  --}}

    {{-- footer  --}}
    @include('frontend.inc.footer')
    {{-- footer  --}}
  </div>

  <script src="{{asset('/')}}js/jquery-3.3.1.min.js"></script>
  <script src="{{asset('/')}}js/jquery-ui.js"></script>
  <script src="{{asset('/')}}js/popper.min.js"></script>
  <script src="{{asset('/')}}js/bootstrap.min.js"></script>
  <script src="{{asset('/')}}js/owl.carousel.min.js"></script>
  <script src="{{asset('/')}}js/jquery.magnific-popup.min.js"></script>
  <script src="{{asset('backend/js/alertify.min.js')}}"></script>
  <script src="{{asset('/')}}js/aos.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
  <script>
      @if (session()->get('success'))
          toastr.success("{{ session()->get('success') }}");
      @endif
      @if (session()->get('error'))
          toastr.error("{{ session()->get('error') }}");
      @endif
      @if (count($errors))
          @foreach ($errors->all() as $error)
              toastr.error("{{$error}}");
          @endforeach
      @endif
  </script>
  @yield('customjs')
  <script src="{{asset('/')}}js/main.js"></script>


  </body>
</html>

