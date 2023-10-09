@if(setting('site.showIndex'))
<section id="explorador" class="explorador">
    <div class="central">

        <ul class="accordion" {{ Route::current()->getName() !=='home' ? 'data-accordion' : ''}}>
            <li class="accordion-navigation {{ Route::current()->getName() =='home' ? 'active' : ''}}">
                <a href="{{ Route::current()->getName() !=='home' ? '#panel1a' : ''}}"
                   class="bot_explo_interno" {{ Route::current()->getName() =='home' ? 'aria-expanded="true"' : ''}}>
                    <h2>
                        EXPLORADOR {!! Route::current()->getName() !=='home' ? ' &bull; CLIQUE PARA UMA NOVA PESQUISA' : ''!!}
                    </h2>
                </a>
                <div id="panel1a" class="content {{ Route::current()->getName() =='home' ? 'active' : ''}}">
                    <div class="col_3-wrapper">
                        <div class="col_3">
                            <div class="box_explorador">
                                <img src="{{asset('img/img_ex1.png')}}" alt="">

                                <h3>ESCOLHA UM ESTADO</h3>

                                <form>
                                    <select name="UF" class="explorerSelectState">
                                        <option value="">SELECIONE</option>
                                        @foreach($states as $state)
                                            <option value="{{$state->acronym}}"
                                                {{(!empty($selectedState) && $selectedState === $state->acronym?'selected':'' )}}>
                                                {{$state->name}}
                                            </option>
                                        @endforeach
                                    </select>
                                </form>
                            </div>
                        </div><!-- col_3 -->

                        <div class="col_3 box_filtro_busca">
                            <div class="box_explorador">
                                <img src="{{asset('img/img_ex2.png')}}" alt="">

                                <h3>PESQUISE <br>PELO NOME</h3>

                            </div>
                            <div class="filtro_busca" style="display: none;">
                                <form method="get" action="{{route('search-by-name')}}">
                                    <input type="search" name="name">

                                    <input type="submit" value="buscar">
                                </form>
                            </div>
                        </div><!-- col_3 -->

                        <!--FILTRE POR EIXO OU INDICADOR
                            <div class="col_3 filtro_box">

                            <div class="box_explorador">
                                <img src="{{asset('img/img_ex3.png')}}" alt="" onclick="return false;">
                                <h3>FILTRE POR EIXO<br>OU INDICADOR</h3>
                            </div>

                            <div class="filtro_estado" style="display: none;">

                                <form>
                                    <select name="UF" id="stateSelectorExplorerPanel">
                                        <option value="">POR ESTADO</option>

                                        @foreach($states as $state)
                                            <option value="{{strtolower($state->acronym)}}"
                                                    data-name="{{$state->name}}">
                                                {{$state->name}}
                                            </option>
                                        @endforeach

                                    </select>
                                </form>

                                <strong>OU</strong>

                                <br>

                                <a href="#" class="botao_br" data-reveal-id="modal_filtro_porperty"> BRASIL</a>

                            </div>
                            

                            <div id="modal_filtro_porperty"
                                 class="reveal-modal xlarge"
                                 data-reveal
                                 aria-labelledby="modalTitle"
                                 aria-hidden="true"
                                 role="dialog">

                                <div id="lista_filtro_criterio">
                                    <div class="title_box">
                                        <h5>
                                            <strong class="stateSubstitute">BR</strong> Escolha o Eixo ou Indicador
                                        </h5>
                                    </div>

                                    @foreach($statsLinks as $statLink)

                                        <div class="col_3">

                                            <h3>
                                                <a class="substituteLink"
                                                   href="{{route('filtro',['br',$statLink['link']])}}">{{$statLink['name']}}</a>
                                            </h3>
                                            <ul>
                                                @foreach($statLink['indicators'] as $indicator)
                                                    <li>
                                                        <i class="fa fa-caret-right"></i>
                                                        <a class="substituteLink"
                                                           href="{{ route('filtro-indicador',['br',$statLink['link'],$indicator['link']])}}">{{$indicator['name']}}</a>
                                                        <br>
                                                    </li>
                                                @endforeach
                                            </ul>

                                        </div>

                                    @endforeach

                                </div>

                                <a class="close-reveal-modal" aria-label="Close">&#215;</a>
                            </div>
    


                        </div>
                        FILTRE POR EIXO OU INDICADOR -->

                        <div class="col_3">
                            <a class="box_explorador" href="{{route('crie-seu-indice')}}">
                                <img src="{{asset('img/img_ex4.png')}}" alt="">
                                <h3>CRIE SEU<br>PRÓPRIO ÍNDICE</h3>
                            </a>
                        </div>
                    </div>
                </div>
            </li>
        </ul>

    </div>

</section><!-- explorador -->
@endif
