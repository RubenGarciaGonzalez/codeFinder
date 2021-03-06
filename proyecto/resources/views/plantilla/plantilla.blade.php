<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="{{asset('material/assets/css/material-kit.css')}}" rel="stylesheet" />
    <link rel="stylesheet" type="text/css"
        href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{asset('node_modules/animate.css/animate.min.css')}}">
    <link href="https://fonts.googleapis.com/css?family=Rubik:500&display=swap" rel="stylesheet">
    <link rel="icon" href="{{asset('img/icon.png')}}" sizes="80x80">
    <link href="https://fonts.googleapis.com/css?family=Poppins:500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    {{-- HighLigher --}}
    <link rel="stylesheet" href="{{ asset('highlight/styles/railscasts.css') }}">
    <title>@yield('titulo')</title>
    {{-- <script src="{{ asset('js/app.js') }}" defer></script> --}}
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- Responsive tables --}}
    <link rel="stylesheet" href="{{ asset('responsiveTables/responsivetables.css') }}">
    {{-- Fuente de Google --}}
    <link href="https://fonts.googleapis.com/css2?family=Baloo+Bhaina+2&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
</head>
<body>
        @include('sweetalert::alert')
        @yield('contenido')

        <!--Scripts necesarios para la funcionalidad de la página-->
    <script src="{{asset('material/assets/js/core/jquery.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('material/assets/js/core/popper.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('material/assets/js/core/bootstrap-material-design.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('material/assets/js/plugins/moment.min.js')}}"></script>
    <script src="{{asset('material/assets/js/plugins/bootstrap-datetimepicker.js')}}" type="text/javascript"></script>
    <script src="{{asset('material/assets/js/plugins/nouislider.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('material/assets/js/material-kit.js')}}" type="text/javascript"></script>
    {{-- HighLighter Script --}}
    <script src="{{ asset('highlight/highlight.pack.js') }}"></script>
    {{-- Script Propio --}}
    <script src="{{ asset('js/script.js') }}"></script>
    <script src="{{ asset('js/validaciones.js') }}"></script>
    {{-- Responsive tables --}}
    <script src="{{ asset('responsiveTables/responsivetables.js') }}"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    
</body>
</html>
