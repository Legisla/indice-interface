@extends('layouts.base')

@section('title','Legisla Brasil - Home')

@section('content')
    <section id="topo_interna">

        <div class="central">
            <h1>
                Seu resultado
            </h1>
        </div>
    </section><!-- topo -->
    <br clear="all">

    @include('layouts.explorerPanel')

    <br clear="all">

    <section id="dados">
        <div class="central">

            <div id="lista_criterio">
                <div class="title_box">
                    <h5>Critérios que você personalizou: <strong>{{$selectedState ?: 'Brasil'}}</strong></h5>
                </div>

                <form method="post" id="hiddenForm">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                    <input type="hidden" name="uf" value="{{ $stateId }}" id="hiddenInputState"/>

                    @foreach($axes as $axis)
                        <div class="col_3" style="padding: 20px 40px">
                            <h3>{{$axis->name}}</h3>
                            <ul>
                                @foreach($axis->indicators as $indicator)

                                    <li style="display: {{$indicators[$indicator->id]==1?'none':'block' }}">
                                        <i class="fa fa-caret-right"></i> {{$indicator->name}}<br>
                                        <strong>{{$indicators[$indicator->id] == 2 ?'Muito relevante':'Pouco relevante' }}</strong>
                                    </li>

                                    <input type="hidden" name="indicators[{{$indicator->id}}]"
                                           value="{{$indicators[$indicator->id]}}">

                                @endforeach
                            </ul>
                        </div><!-- col_3 -->
                    @endforeach
                </form>

            </div>

            <a href="{{route('crie-seu-indice')}}" class="link_spec" >
                Alterar Parâmetros
            </a>

            <div class="box_top_title">
                <h3><strong>DEPUTADOS</strong></h3>

                <br clear="all">
                <p>RESULTADO EM ORDEM ALFABÉTICA</p>
            </div>

            <div class="box_top_select">

                <form>
                    <select id="stateCustomIndex" name="uf">
                        <option value="">ESCOLHA</option>
                        <option value="">BRASIL</option>
                        @foreach($states as $state)
                            <option value="{{$state->id}}" {{$state->id == $stateId ? 'selected':''}}>
                                {{$state->name}}
                            </option>
                        @endforeach
                    </select>
                    <!-- <select id="classificationCustomIndex" name="classificationCustomIndex">
                        <option value="">{{empty($stars)?'Alterar Classificação':'Limpar Classificação'}}</option>
                        <option value="5" {{!empty($stars) && $stars == 5 ?'selected':''}}>5 estrelas
                        </option>
                        <option value="4" {{!empty($stars) && $stars == 4 ?'selected':''}}>4 estrelas
                        </option>
                        <option value="3" {{!empty($stars) && $stars == 3 ?'selected':''}}>3 estrelas
                        </option>
                        <option value="2" {{!empty($stars) && $stars == 2 ?'selected':''}}>2 estrelas
                        </option>
                        <option value="1" {{!empty($stars) && $stars == 1 ?'selected':''}}>1 estrela</option>
                    </select> -->
                </form>

            </div>

            <br clear="all">

            <div class="lista_resultados">

                @foreach( $congresspeople as $congressperson )

                    <div class="box_dep"> <!-- col_2 box_dep -->
                        <a href="{{route('deputado',['id'=>$congressperson->external_id])}}"
                           title="Nome do Deputado">
                            <img src="{{$congressperson->uri_photo}}" style="max-height: 152px" alt="">
                        </a>

                        <strong>{{$congressperson->name}}</strong>
                        <p>
                            {{$congressperson->state_acronym}}<br>
                            {{$congressperson->party_acronym}}<br>
                            [{{$congressperson->mainScore}} / {{$congressperson->stars}}]
                        </p>

                        @if ($congressperson->stars == 5)
                        <div class="ranking">
                            <i class="fa fa-star font_ativo"></i>
                            <i class="fa fa-star font_ativo"></i>
                            <i class="fa fa-star font_ativo"></i>
                            <i class="fa fa-star font_ativo"></i>
                            <i class="fa fa-star font_ativo"></i>
                        </div>
                        @endif

                    </div>
                    <!-- col_2 box_dep -->

                @endforeach

            </div>

        </div>
    </section><!-- dados -->
    <br clear="all">

@endsection
