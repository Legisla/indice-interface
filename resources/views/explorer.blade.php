@extends('layouts.base')

@section('title','Legisla Brasil - Home')

@section('content')
    <section id="topo_interna">

        <div class="central">
            <h1 class="{{!empty($filterActive)?'title-filter-page':''}}">
                {!!$title!!}
            </h1>
        </div>
    </section><!-- topo -->
    <br clear="all">

    @include('layouts.explorerPanel')

    <br clear="all">

    <section id="dados">
        <div class="central">

            <div class="box_top_title">
                <h3><strong>DEPUTADOS</strong></h3>

                @if(!empty($stars))

                    <div class="ranking">
                        <i class="fa fa-star font_ativo"></i>
                        <!-- <i class="fa fa-star {{ ( $stars * 20 ) > 20? 'font_ativo' : ''}}"></i>
                        <i class="fa fa-star {{ ( $stars * 20 ) > 40? 'font_ativo' : ''}}"></i>
                        <i class="fa fa-star {{ ( $stars * 20 ) > 60? 'font_ativo' : ''}}"></i>
                        <i class="fa fa-star {{ ( $stars * 20 ) > 80? 'font_ativo' : ''}}"></i> -->
                    </div>

                @endif

                <br clear="all">
                <p>RESULTADO EM ORDEM ALFABÉTICA</p>
            </div>

            <div class="box_top_select">

                @include('layouts.site_components.more-info')

                <form>
                    <select id="UF"
                            name="UF"
                            data-params="{{$uri??''}}"
                            class="{{ !empty($filterActive)?'filterSelectState':'explorerSelectState'}}">
                        <option value="">{{empty($selectedState)?'Alterar Estado':'Brasil'}}</option>
                        @foreach($states as $state)
                            <option value="{{$state->acronym}}"
                                {{(!empty($selectedState) && $selectedState === $state->acronym?'selected':'' )}}>
                                {{$state->name}}
                            </option>
                        @endforeach
                    </select>

                    <!-- <select id="classificacao"
                            name="classificacao"
                            class="{{!empty($filterActive)?'filterSelectRate':'explorerSelectRate'}}">
                        <option value="">{{empty($stars)?'Alterar Classificação':'Limpar Classificação'}}</option>
                        <option value="cinco-estrelas" {{!empty($stars) && $stars === 5 ?'selected':''}}>5 estrelas
                        </option>
                        <option value="quatro-estrelas" {{!empty($stars) && $stars === 4 ?'selected':''}}>4 estrelas
                        </option>
                        <option value="tres-estrelas" {{!empty($stars) && $stars === 3 ?'selected':''}}>3 estrelas
                        </option>
                        <option value="duas-estrelas" {{!empty($stars) && $stars === 2 ?'selected':''}}>2 estrelas
                        </option>
                        <option value="uma-estrela" {{!empty($stars) && $stars === 1 ?'selected':''}}>1 estrela</option>
                    </select> -->
                </form>

            </div>

            <!-- MODAL EXPLICATIVO -->
            <div id="myModal" class="reveal-modal" data-reveal aria-labelledby="modalTitle" aria-hidden="true"
                 role="dialog">

                <div class="col_12">

                    <p>
                        A pontuação final dos parlamentares é obtida pela média em todos os indicadores. Dessa forma, as
                        estrelas são dadas a partir da faixa em que a nota do parlamentar se encontra. A classificação
                        varia de uma estrela (nota 1,3 ou menos) a cinco estrelas (notas maiores que 5,3). Para mais
                        detalhes, consulte a página Metodologia.
                    </p>

                </div>

                <a class="close-reveal-modal" aria-label="Close">&#215;</a>
            </div><!-- MODAL EXPLICATIVO -->

            <br clear="all">

            <div class="lista_resultados">

                @if($congresspeople->isEmpty())
                    <div class="text-center">
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <p>Nenhum parlamentar encontrado</p>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                    </div>
                @endif
                <!-- LISTA REPETIÇÃO -->
                @foreach( $congresspeople as $congressperson )

                    <div class="box_dep"> <!-- col_2 box_dep -->
                        <a href="{{route('deputado',['id'=>$congressperson->external_id])}}"
                           title="Nome do Deputado">
                            <img src="{{$congressperson->uri_photo}}" style="max-height: 152px" alt="">
                        </a>

                        <strong>{{$congressperson->name}}</strong>
                        <p>
                            {{$congressperson->state_acronym}}<br>
                            {{$congressperson->party_acronym}}
                        </p>

                        <div class="ranking">
                            <i class="fa fa-star font_ativo"></i>
                            <i class="fa fa-star {{ $congressperson->rate > 20? 'font_ativo' : ''}}"></i>
                            <i class="fa fa-star {{ $congressperson->rate > 40? 'font_ativo' : ''}}"></i>
                            <i class="fa fa-star {{ $congressperson->rate > 60? 'font_ativo' : ''}}"></i>
                            <i class="fa fa-star {{ $congressperson->rate > 80? 'font_ativo' : ''}}"></i>
                        </div>

                    </div>
                    <!-- col_2 box_dep -->

                @endforeach

            </div>

        </div>
    </section><!-- dados -->
    <br clear="all">
@endsection
