@extends('layouts.base')

@section('title','Legisla Brasil -  Deputado '.$congressperson->congressperson_name)

@section('content')

    <section id="topo_interna"> 

        <div class="central-topo">
            <h1>
                Deputad{{$congressperson->sex === 'F' ? 'a' : 'o'}} {{$congressperson->congressperson_name}}
            </h1>
        </div>
    </section><!-- topo -->

    <br>

    @include('layouts.explorerPanel')

    <br>

    <section id="dados">
        <div class="central">

            @include('layouts.site_components.more-info')

            <!-- MODAL EXPLICATIVO -->
            <div id="myModal" class="reveal-modal" data-reveal aria-labelledby="modalTitle" aria-hidden="true"
                 role="dialog">

                <div class="col_12">
                    <p>Ao avaliar um parlamentar, é importante ter em mente que não é esperado que eles alcancem nota
                        máxima em todos os eixos e indicadores, uma vez que é normal parlamentares se utilizarem de
                        ferramentas que sejam mais condizentes com o seu perfil e base eleitoral.
                        Por isso, ao analisar a atuação de um parlamentar, se atente se o parlamentar zera muitos
                        indicadores de um mesmo eixo ou se até mesmo zera um eixo completo, pois isso pode ser um ponto
                        de atenção</p>
                </div>

                <a class="close-reveal-modal" aria-label="Close">&#215;</a>
            </div>

            <div class="top_info">
                <div class="box_1 col_4">
                    <img src="{{$congressperson->uri_photo}}" alt="">
                </div>
                <div class="box_2 col_3">

                    @if ($congressperson->stars == 5)
                    <div class="ranking">
                        <i class="fa fa-star font_ativo"></i>
                        <i class="fa fa-star font_ativo"></i>
                        <i class="fa fa-star font_ativo"></i>
                        <i class="fa fa-star font_ativo"></i>
                        <i class="fa fa-star font_ativo"></i>
                    </div>
                    @endif
                    <br>

                    <h2>{{$congressperson->congressperson_name}}</h2>

                    <h4>
                        {{$congressperson->state_name}} - {{$congressperson->party_acronym}}
                        <br>
                        {{$congressperson->title}}
                        <br>
                        Em Exercicio: {{$congressperson->situation ==='Exercício' ? 'Sim' : 'Não'}}
                    </h4>

                </div>


                <div class="box_3 col_5">
                    <ul>
                        <li>
                            <div class="ico_tempo">
                                <strong>{{$officeTime}}</strong><br>{{$officeTime > 1 ? 'Meses' : 'Mês'}}
                            </div>
                            <h5>Tempo de mandato</h5>
                        </li>
                        {{--    <li>--}}
                        {{--        <div class="ico_tempo">--}}
                        {{--            <strong>{{$partyTime}}</strong><br>Ano{{$partyTime > 1 ? 's' : ''}}--}}
                        {{--        </div>--}}
                        {{--        <h5>Tempo de partido</h5>--}}
                        {{--    </li>--}}
                    </ul>
                    <div class="box_partido">
                        <p>Partidos durante a legislatura</p>
                        <strong>{{$congressperson->old_parties}}</strong>
                    </div>

                    <div class="box_description">
                        <p>
                            {{$congressperson->observation}}
                        </p>
                    </div>

                </div>
            </div>

            <div class="button_info">
                <div class="box_1 col_4">
                    <div class="box_dados">
                        {{--      <h5>Última eleição:</h5>--}}
                        {{--      <span>Votos obtidos</span>--}}
                        {{--      <strong>{{number_format($congressperson->last_votes,0,',','.')}}</strong>--}}
                        {{--      <br>--}}
                        {{--      <span>Coeficiente eleitoral</span>--}}
                        {{--      <strong>{{number_format($congressperson->last_electoral_coefficent,0,',','.')}}</strong>--}}
                    </div>
                </div>

                <?php
                $topics = $congressperson->preferred_themes ? json_decode($congressperson->preferred_themes, true) : false;
                ?>
                @if($topics)
                    <div class="box_2 col_4">
                        <h5>Temas mais trabalhados:</h5>

                        <ul>
                            @foreach($topics as $topic)
                                <li><i class="fa fa-caret-right"></i>
                                    {{$topic['tema']}}
                                </li>
                            @endforeach

                        </ul>
                    </div>
                @endif
                <div class="box_3 col_4">
                    <h5>Gastos de gabinete:</h5>
                    <strong>R$ {{number_format($congressperson->expenditure,2,',','.')}}</strong>
                    <br>

                    <h5>Média nacional:</h5>
                    <strong>R$ {{number_format($nationalExpenditure,2,',','.')}}</strong>
                    <br>

                    <h5>Média {{$congressperson->state_name}}:</h5>
                    <strong>R$ {{number_format($stateExpenditure,2,',','.')}}</strong>
                    <br>

                </div>
            </div>
        </div>
    </section><!-- dados -->

    <br>

    <section id="dados_grafico">
        <div class="central">
            <h2 class="col_12">VEJA AS NOTAS</h2>
            
            @foreach($statsData as $axis=>$stat)

                <div class="col_3">'
                    <div class="box_grafico">
                        <h4>{{$stat['info']['axisName']}}</h4>

                        <ul class="box_dados_graf">
                            <li>
                                <strong class="cor1">{{$stat['indicatorsMean']['deputyMean']}}</strong><br>
                                {{$congressperson->congressperson_name}}
                            </li>
                            <li>
                                <strong class="cor2">{{$stat['indicatorsMean']['stateMean']}}</strong><br>
                                Média {{$congressperson->state_name}}
                            </li>
                            <li>
                                <strong class="cor3">{{$stat['indicatorsMean']['nationalMean']}}</strong><br>
                                Média Brasil
                            </li>
                        </ul>
                        
                        <div class="bloco_grafico" id="cntr{{$axis}}">
                            <!-- COLOCAR GRAFICO AQUI -->
                        </div>

                        @foreach($stat['info']['indicators'] as $idIndicator=>$nameIndicator)
                            <p><strong>{{$idIndicator}}.</strong> {{$nameIndicator}}</p>
                        @endforeach

                        <script>
                                
                                
                            function translateIndicators(indicators) {
                                var translated = {!! json_encode($stat['info']['indicators']) !!};
                                console.log(translated);
                                for (var key in indicators) {
                                    translated[key] = indicators[key];
                                }
                                return translated;
                            }

                            const chart{{$axis}} = echarts.init(document.getElementById('{{'cntr'.$axis}}'), null, {
                                renderer: 'canvas',
                                useDirtyRect: false
                            }).setOption({
                                    grid: {left: '5%', right: '7%', top: 20, bottom: 25},
                                    color: ['#810f36', '#b82251', '#fa2567'],
                                    tooltip: {trigger: 'axis'},
                                    dataset: {
                                        source: [
                                            {!! $stat['indicatorGraphData'] !!}
                                        ]
                                    },
                                    xAxis: {type: 'category'},
                                    yAxis: {show: false, min: 0, max: 10},
                                    series: [{type: 'bar'}, {type: 'bar'}, {type: 'bar'}]
                                }
                            );

                        </script>

                    </div>
                </div><!-- col_3 -->

            @endforeach
        </div>
    </section><!-- dados_grafico -->
    <br>

@endsection
