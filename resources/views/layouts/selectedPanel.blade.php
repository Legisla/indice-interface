@if(setting('site.showIndex'))
<section id="selected" class="explorador white">
    <div class="central">

        <ul class="accordion">
            <li class="accordion-navigation {{ Route::current()->getName() =='home' ? 'active' : ''}}">
                <a
                   class="bot_explo_interno" {{ Route::current()->getName() =='home' ? 'aria-expanded="true"' : ''}}>
                    <h2>
                        CONFIRA OS DESTAQUES
                    </h2>
                </a>
                <div id="panel1a" class="content {{ Route::current()->getName() =='home' ? 'active' : ''}}">
                    <div class="col_3-wrapper">
                        <div class="col_3">
                            <div class="box_explorador">
                                <!-- <img src="{{asset('img/img_ex1.png')}}" alt=""> -->

                                <h3>DESTAQUES POR ESTADO</h3>
                                <form>
                                    <select name="UF" class="explorerTopState">
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

                        <div class="col_3">
                            <div class="box_explorador">
                                <!-- <img src="{{asset('img/img_ex2.png')}}" alt=""> -->

                                <h3>DESTAQUES POR PARTIDO</h3>
                            
                            <form>
                                    <select name="PARTIDO" class="explorerTopParty">
                                        <option value="">SELECIONE</option>
                                        @foreach(App\Models\Party::getActiveParties() as $party)
                                            <option value="{{$party->acronym}}" {{(!empty($selectedState) && $selectedParty === $party->acronym?'selected':'' )}}>
                                                {{$party->acronym}}
                                            </option>
                                        @endforeach
                                    </select>
                                </form>
                            </div>
                        </div><!-- col_3 -->

                        <div class="col_3 filtro_box">

                            <div class="box_explorador">
                                <!-- <img src="{{asset('img/img_ex3.png')}}" alt="" onclick="return false;"> -->
                                <h3>DESTAQUES POR EIXO
                            </div>

                            <div class="filtro_estado" style="display: none;">

                                <form>
                                    <select name="UF" id="stateSelectorExplorerPanelSelected">
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

                                <a href="#" class="botao_br" data-reveal-id="modal_destaque_property"> BRASIL</a>

                            </div>


                            <!-- AQUI TA O FILTRO DA SELEÇÃO DE OPÇÕES -->
                            <div id="modal_destaque_property"
                                 class="reveal-modal xlarge"
                                 data-reveal
                                 aria-labelledby="modalTitle"
                                 aria-hidden="true"
                                 role="dialog">

                                <div id="lista_destaque_criterio">
                                    <div class="title_box">
                                        <h5>
                                            <strong class="stateSubstitute">BR</strong> Escolha o Eixo ou Indicador
                                        </h5>
                                    </div>

                                    @foreach($statsLinks as $statLink)

                                        <div class="col_3">

                                            <h3>
                                                <a class="substituteLink"
                                                   href="{{route('topn',['br',$statLink['link']])}}">{{$statLink['name']}}</a>
                                            </h3>
                                        </div><!-- col_3 -->

                                    @endforeach

                                </div>

                                <a class="close-reveal-modal" aria-label="Close">&#215;</a>
                            </div>
                            <!-- AQUI TA O FILTRO DA SELEÇÃO DE OPÇÕES -->


                        </div><!-- col_3 -->

                    </div>
                </div>
            </li>
        </ul>

    </div>

</section><!-- explorador -->
@endif
