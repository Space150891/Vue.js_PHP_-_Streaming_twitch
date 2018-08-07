<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src='https://www.google.com/recaptcha/api.js'></script>
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
        
        <script>
            
            var pageUrl = window.location.pathname;
            if(pageUrl == "/twitch/callback") {
                @if (isset($access_token))
                    <?php \Log::info('in view '. $access_token); ?>
                    window.access_token = "{{($access_token)}}";
                @endif
                localStorage.setItem('userToken', window.access_token);
                // window.location.replace("http://localhost:8081/");
                window.location = '/';
            }

        </script>
    </head>
    <body>
        <div id="app" class="container-fluid">
            <header>
                <up-nav></up-nav>
                <menu-block></menu-block>
            </header>
            <main>
                <router-view></router-view>

            </main>
        </div>

            

            
        {{-- Scripts --}}
        <script src="{{ mix('/js/app.js') }}"></script>
        
        

        
        @yield('footer_scripts')

    </body>
</html>
