@extends('layouts.base')

@section('title','Legisla Brasil - Contatos')

@section('content')

    <section id="topo_interna_institucional">

        <div class="central">
            <h1>
                Contato
            </h1>
        </div>
    </section><!-- topo -->

    <br clear="all">

    @include('layouts.explorerPanel')

    <br clear="all">

    <section id="contato">
        <div class="central">
            <div class="col_4">

                <div>
                    {!! $contactDetails ? $contactDetails->content : "" !!}
                </div>

                <div class="redes_contato">
                    <a href="{!! setting('social.facebook') !!}" title="" target="_blank">
                        <i class="fa fa-facebook-square"></i>
                    </a>
                    <a href="{!! setting('social.linkedin') !!}" title="" target="_blank">
                        <i class="fa fa-linkedin-square"></i>
                    </a>
                    <a href="{!! setting('social.instagram') !!}" title="" target="_blank">
                        <i class="fa fa-instagram"></i>
                    </a>
                </div>
            </div>
            <div class="col_8">

                @if (session()->has('success-message'))
                    <div class="text-center success-green">
                        Formulário salvo com sucesso!
                    </div>
                @endif

                @if($errors->any())
                    @foreach($errors->getMessages() as $this_error)
                        <div class="text-center failure-red">
                            {{$this_error[0]}}
                        </div>
                    @endforeach
                @endif

                <form method="post">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                    <label for="name">
                        Nome<br>
                        <input type="text" name="name" value="{{old('name')}}" required>
                    </label>
                    <label for="phone">
                        Telefone<br>
                        <input type="text" name="phone" value="{{old('phone')}}" class="telefone" required>
                    </label>
                    <label for="email">
                        E-mail<br>
                        <input type="email" name="email" value="{{old('email')}}" required>
                    </label>
                    <label for="message">
                        Mensagem<br>
                        <textarea name="message" required>{{old('message')}}</textarea>
                    </label>

                    <input type="submit" name="Enviar" value="Enviar">
                </form>
            </div>
        </div>
    </section><!-- dados -->
    <br clear="all">
@endsection
