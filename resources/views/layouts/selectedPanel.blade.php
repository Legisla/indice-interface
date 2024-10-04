@if(setting('site.showIndex'))
<section id="selected" class="explorador white">
    <div class="central">

        <ul class="accordion">
            <img class="curva-home" src="{{asset('img/idv-curva-home4.png')}}" alt="Curva">
            <li class="accordion-navigation {{ Route::current()->getName() =='home' ? 'active' : ''}}">
                <a
                   class="bot_explo_interno" {{ Route::current()->getName() =='home' ? 'aria-expanded="true"' : ''}}>
                    <h2>
                        CONFIRA OS DESTAQUES
                    </h2>
                    <p>Saiba quem são os 3 melhores deputados de cada partido/estado/eixo</p>
                </a>
                
                <div id="panel1a" class="content {{ Route::current()->getName() =='home' ? 'active' : ''}}">
                    <div class="col_3-wrapper">
                        <div class="col_3">
                            <div class="box_explorador">
                                <!-- <img src="{{asset('img/img_ex1.png')}}" alt=""> -->

                                <h3>DESTAQUES POR ESTADO</h3>
                                <form>
                                    <select name="UF" class="explorerTopState">
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

                        <div class="col_3">
                            <div class="box_explorador">
                                <!-- <img src="{{asset('img/img_ex2.png')}}" alt=""> -->

                                <h3>DESTAQUES POR PARTIDO</h3>
                            
                            <form>
                                    <select name="PARTIDO" class="explorerTopParty">
                                        <option value="">Selecione</option>
                                        @foreach(App\Models\Party::getActiveParties() as $party)
                                            <option value="{{$party->acronym}}" {{(!empty($selectedState) && $selectedParty === $party->acronym?'selected':'' )}}>
                                                {{$party->acronym}}
                                            </option>
                                        @endforeach
                                    </select>
                                </form>
                            </div>
                        </div><!-- col_3 -->

                        <div class="col_3">

                            <div class="box_explorador">
                                <!-- <img src="{{asset('img/img_ex3.png')}}" alt="" onclick="return false;"> -->
                                <h3>DESTAQUES POR<br/>EIXO</h3>

                            <form>
                                <select name="EIXO" class="explorerTopAxis">
                                    <option value="">Selecione</option>
                                    
                                    @foreach($statsLinks as $statLink)
                                    <option value="{{$statLink['link']}}">{{$statLink['name']}}</option>
                                    @endforeach
                                </select>
                            </form>
                            </div>
                        </div><!-- col_3 -->

                    </div>
                </div>
            </li>
        </ul>

    </div>

</section><!-- explorador -->
@endif
