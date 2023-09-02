@extends('layouts.base')

@section('title','Legisla Brasil - Home')

@section('content')

    <section id="topo_interna">

        <div class="central">
            <h1>
                Crie seu índice
            </h1>
        </div>
    </section><!-- topo -->

    <br clear="all">

    <section id="dados" class="box_indice">
        <div class="central">

            <div class="col_12">
                <h2>Você decide o peso de cada indicador!</h2>
                <p>
                    A metodologia do Índice Legisla Brasil foi desenvolvida considerando peso 1 para todos os eixos e
                    indicadores, ou seja, todos possuem a mesma importância no cálculo das notas individuais dos
                    parlamentares.
                </p>
                <p>
                    Criamos essa ferramenta na plataforma para que cada pessoa possa personalizar o índice com os
                    indicadores que considera mais importantes.
                </p>
                <p>
                    Ao ter a possibilidade de criar seu próprio índice, você poderá dar 3 pesos diferentes para um
                    indicador: <strong>não relevante (atribuindo peso 0), relevante (peso 1, como a metodologia
                        original) e
                        muito relevante (peso 2)</strong>. Ao final, basta selecionar se deseja aplicar esses pesos para
                    algum estado
                    específico ou se para o Brasil todo.
                </p>
                <br>
                <h3 class="text-center">Altere ao menos um parâmetro:</h3>
            </div>

            <div class="listas_indice">
                <form method="post">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                    <div class="cntr_4_2_1">
                        @foreach($axes as $axis)
                            <div class="col_3 not_col_3">
                                <div class="bloco_indice">

                                    <div class="title_box">
                                        <h5>{{$axis->name}}</h5>
                                    </div><!-- title_box -->

                                    @foreach($axis->indicators as $indicator)
                                        <div class="dados_box">

                                            <div class="lcol">

                                                <input type="range" name="indicators[{{$indicator->id}}]"
                                                       class="rangeCustomIndex" value="1" min="0" max="2">

                                                <div class="textRelevance">relevante (x1)</div>

                                            </div>

                                            <div class="rcol">
                                                <p>{{$indicator->name}}</p>
                                            </div>
                                        </div><!-- dados_box -->

                                    @endforeach

                                </div>
                            </div><!-- col_3 -->

                        @endforeach
                    </div>
                    <br clear="all">

                    <div class="center_box">

                        <select id="UF" name="uf" class="height42px">
                            <option value="">BRASIL</option>
                            @foreach($states as $state)
                                <option value="{{$state->id}}">
                                    {{$state->name}}
                                </option>
                            @endforeach

                        </select>

                        <input type="submit"
                               class="customindexsubmit disabled"
                               name="Gerar Resultado"
                               value="GERAR RESULTADO"
                               id="customIndexSubmit">
                    </div>
                </form>
            </div>

        </div>
    </section><!-- dados -->
    <br clear="all">
@endsection
