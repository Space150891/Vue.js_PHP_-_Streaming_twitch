<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        {{-- CSRF Token --}}
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@if (trim($__env->yieldContent('template_title')))@yield('template_title') | @endif {{ config('app.name', Lang::get('titles.app')) }}</title>
        <meta name="description" content="">
        <link rel="shortcut icon" href="/favicon.ico">

        {{-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries --}}
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
            <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

        {{-- Fonts --}}
        @yield('template_linked_fonts')

        {{-- Styles --}}
        <link href="{{ mix('/css/app.css') }}" rel="stylesheet">

        @yield('template_linked_css')

        
        @yield('head')
        @yield('header_scripts')
    </head>
    <body>
        <div id="app" class="container">
            <menu-block></menu-block>

            <!-- <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <a class="navbar-brand" href="#">{{ config('app.name') }}</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item active">
                            <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Directory</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Prices</a>
                        </li>
                    </ul>
                </div>
            </nav> -->

            <main class="py-4">

                <div class="row">
                    <div class="col-md-10">
                        @yield('content')
                    </div>
                    <div class="col-md-2 adv-section">
                        advertisment
                    </div>
                </div>

            </main>

        </div>

        {{-- Scripts --}}
        <script src="{{ mix('/js/app.js') }}"></script>

        
        @yield('footer_scripts')

    </body>
</html>
