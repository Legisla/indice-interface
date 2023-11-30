@extends('layouts.base')

@section('title','Legisla Brasil - Home')

@section('content')

    <section id="topo" class="top_home">
        <div class="central">
            <div class="col_5">
                <img src="{{asset('img/imagem-top-home.png')}}" alt="imagem de topo da home">
            </div>
            <div class="col_7">
                {!! $homePage->content !!}
            </div>
        </div>
    </section><!-- topo -->

    <br clear="all">
    
    @if(setting('site.showIndex'))

        @include('layouts.explorerPanel')

    <br clear="all">

        @include('layouts.selectedPanel')

        <section id="destaque">
            <div class="central">
                <ul>
                    <li>
                        <a href="{{route('5-star')}}" title="">
                            <img src="{{asset('img/img_dest1.jpg')}}" alt="">
                        </a>
                    </li>
                    <li>
                        <a href="{{route('metodologia')}}" title="">
                            <img src="{{asset('img/img_dest2.jpg')}}" alt="">
                        </a>
                    </li>
                </ul>
            </div>
            <div style="display:flex;justify-content:center; align-items: center;">
                        <a href="https://www.legislabrasil.org/indice-legisla-acesse-o-relatorio/" target="_blank" title="">
                            <h3 style="background-color:#fa2567; border-radius: 10px;border: solid 4px #FFF; box-shadow: 3px 3px 9px #404040; color:#fff; text-align:center; margin:2em auto; width:100%; padding:5px;">Receba o relatório exclusivo sobre seu mandato</h2>
                        </a>
                </ul>
            </div>
        </section><!-- destaque -->

        <br clear="all">

    @else
        <section id="explorador">

            <div class="section-whe-are-working">
                <div class="img-whe-are-working">
                    <img src="{{asset('img/estamos-trabalhando.png')}}" alt="estamos trabalhando"
                         style="width: 100px;height: auto">
                </div>
                <h2 class="center  white">Estamos trabalhando no Índice Legisla de 2023, analisando os dados da nova
                    legislatura. Em breve você poderá acompanhar o trabalho de quem você votou!</h2>
            </div>

        </section>
    @endif

@endsection
