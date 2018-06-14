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
        <div id="app" class="container-fluid">
            <header>
                <menu-block></menu-block>
            </header>
            <main>
                <left-part></left-part>
                
                <midle-part-home></midle-part-home>
                <!-- <midle-part-price></midle-part-price> -->
                <!-- <midle-part-directory></midle-part-directory> -->
                <!-- <midle-part-bag></midle-part-bag> -->
                <!-- <video-part></video-part> -->
                
                <right-part></right-part>
                

            </main>
            <footer>
                
            </footer>
            

            
        {{-- Scripts --}}
        <script src="{{ mix('/js/app.js') }}"></script>

        
        @yield('footer_scripts')

    </body>
</html>
