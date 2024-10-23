@extends('layouts.base')

@section('title','Legisla Brasil - Sobre O Projeto')

@section('content')
    <section id="topo_interna_institucional">

        <div class="central-topo">
            <h1>
                {{$page->title}}
            </h1>
        </div>
    </section><!-- topo -->
    <!-- <br clear="all"> -->

    <section id="explorador-pages">

        @include('layouts.explorerPanel')
    </section>

    <!-- <br clear="all"> -->

    <section id="sobre">
        <div class="central">

            <div class="container-fluid">

                {!! $page->content !!}

            </div>

        </div>
    </section><!-- sobre -->

    <br clear="all">
@endsection
