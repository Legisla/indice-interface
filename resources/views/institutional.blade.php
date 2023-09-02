@extends('layouts.base')

@section('title','Legisla Brasil - Sobre O Projeto')

@section('content')
    <section id="topo_interna_institucional">

        <div class="central">
            <h1>
                {{$page->title}}
            </h1>
        </div>
    </section><!-- topo -->
    <br clear="all">

    @include('layouts.explorerPanel')

    <br clear="all">

    <section id="sobre">
        <div class="central">

            <div class="container-fluid">

                {!! $page->content !!}

            </div>

        </div>
    </section><!-- sobre -->

    <br clear="all">
@endsection
