@if(setting('site.showIndex'))
<section id="explorador" class="explorador">
    <div class="central">

        <ul class="accordion" {{ Route::current()->getName() !=='home' ? 'data-accordion' : ''}}>
            <li class="accordion-navigation {{ Route::current()->getName() =='home' ? 'active' : ''}}">
                <a href="{{ Route::current()->getName() !=='home' ? '#panel1a' : ''}}"
                   class="bot_explo_interno" {{ Route::current()->getName() =='home' ? 'aria-expanded="true"' : ''}}>
                  
                    <h2>
                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="29" viewBox="0 0 30 29" fill="none">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M22.822 19.1431C26.1751 14.4435 25.7429 7.87411 21.5254 3.65658C16.8263 -1.04251 9.20755 -1.04251 4.50846 3.65658C-0.190633 8.35567 -0.190633 15.9744 4.50846 20.6735C8.72594 24.891 15.2953 25.3232 19.9948 21.9703C20.0292 22.0105 20.0654 22.0498 20.1035 22.0879L25.7835 27.7679C26.5645 28.5489 27.8347 28.5451 28.6158 27.764C29.3968 26.983 29.4007 25.7128 28.6196 24.9317L22.9396 19.2517C22.9015 19.2136 22.8623 19.1774 22.822 19.1431ZM18.6892 6.49272C21.8219 9.62545 21.8219 14.7046 18.6892 17.8373C15.5565 20.9701 10.4773 20.9701 7.3446 17.8373C4.21187 14.7046 4.21187 9.62545 7.3446 6.49273C10.4773 3.36 15.5565 3.36 18.6892 6.49272Z" fill="#B82251"/>
                        </svg>
                        Explore o índice {!! Route::current()->getName() !=='home' ? '  ' : ''!!}
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="7" viewBox="0 0 12 7" fill="none">
                            <path d="M12 0H0L6 7L12 0Z" fill="#EECFB0"/>
                        </svg>
                    </h2>
                   
                </a>
                <div id="panel1a" class="content {{ Route::current()->getName() =='home' ? 'active' : ''}}">
                    <div class="col_3-wrapper">
                        <div class="col_3">
                            <div class="box_explorador">
                                <img src="{{asset('img/idv-img_ex1.png')}}" alt="">

                                <h3>ESCOLHA UM ESTADO</h3>

                                <form>
                                    <select name="UF" class="explorerSelectState">
                                        <option value="">Selecione</option>
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
                                <img src="{{asset('img/idv-img_ex2.png')}}" alt="">

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
                                <img src="{{asset('img/idv-img_ex3.png')}}" alt="">
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
