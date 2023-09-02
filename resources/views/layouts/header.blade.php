<!doctype html>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link href="{{asset('img/favicon.ico')}}" type="image/x-icon" rel="icon"/>
    <link href="{{asset('img/favicon.ico')}}" type="image/x-icon" rel="shortcut icon"/>
    <title>Legisla Brasil - {{str_replace('-',' ',ucfirst(Route::current()->getName()))}}</title>
    <link rel="stylesheet" href="{{asset('css/app.css')}}"/>
    <link rel="stylesheet" href="{{asset('css/style.css')}}"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="{{asset('js/jquery.min.js')}}"></script>
    <script type="text/javascript" src="https://fastly.jsdelivr.net/npm/echarts@5.3.3/dist/echarts.min.js"></script>
    <script src="{{asset('js/modernizr.js')}}"></script>
</head>
<body>

@if(Route::current()->getName() == 'home')
    <header class="header">
@else
    <header class="header_interna">
@endif

        <div class="central nav_central">
            <nav class="top-bar" data-topbar role="navigation" data-options="is_hover: false">
                <ul class="title-area">
                    <li class="toggle-topbar menu-icon"><a href="#"><span></span></a></li>
                </ul>
                <ul class="title-area menu_fechar">
                    <li class="toggle-topbar menu-icon"><a href="#">X</a></li>
                </ul>

                <a href="{{url('')}}" title="Legisla Brasil" id="logo_top">
                    <img src="{{asset('img/marca.png')}}" class="desk_logo" alt="Legisla Brasil">
                    <img src="{{asset('img/marca-change.png')}}" class="mobile_logo" alt="Legisla Brasil">
                </a>

                <section class="top-bar-section">
                    <div>
                        <ul>
                            <li><a href="{{url('')}}" title="Início">Início</a></li>
                            <li><a href="{{route('sobre-o-projeto')}}" title="Sobre o projeto">Sobre o
                                    projeto</a></li>
                            <li><a href="{{route('metodologia')}}" title="Metodologia">Metodologia</a></li>
                            <li><a href="{{route('quem-somos')}}" title="Quem Somos">Quem Somos</a></li>
                            <li><a href="{{route('contatos')}}" title="Contatos">Contatos</a></li>
                        </ul>
                    </div>
                </section>
                <div class="redes_top">
                    <a href="{!! setting('social.facebook') !!}" title="" target="_blank">
                        <i class="fa fa-facebook-square"></i>
                    </a>
                    <a href="{!! setting('social.linkedin') !!}" title="" target="_blank">
                        <i class="fa fa-linkedin-square"></i>
                    </a>
                    <a href="{!! setting('social.instagram') !!}" title="" target="_blank">
                        <i class="fa fa-instagram"></i>
                    </a>
                </div>
            </nav>
        </div>
    </header>
