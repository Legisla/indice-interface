<!doctype html>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link href="{{asset('img/favicon.ico')}}" type="image/x-icon" rel="icon"/>
    <link href="{{asset('img/favicon.ico')}}" type="image/x-icon" rel="shortcut icon"/>
    <title>Legisla Brasil - {{str_replace('-',' ',ucfirst(Route::current()->getName()))}}</title>
    <link rel="stylesheet" href="{{mix('css/app.css')}}"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="{{asset('js/modernizr.js')}}"></script>

    <style>
        .blocked{
            text-align: center;
            position: relative;
            height: 100%;
            width: 100%;
            background: #b82251;
        }
        .blocked form{
            position: absolute;
            top: 40%;
            left: 50%;
            transform: translate(-50%,-50%);
            text-align: center !important;
            float: initial;
        }
        .blocked h4{
            color: #f8991c;
        }
        .blocked input[type=text]{
            display: inline-block;
            width: 200px;
            float: initial !important;
        }
        input[placeholder] {
            text-align: center;
        }
        .blocked input[type=submit]{
            float: initial !important;
            font-size: 14px !important;
            padding: 8px 14px !important;
        }
    </style>

</head>
<body>
<div class="blocked" id="contato">

<form method="post" action="{{route('desbloquear')}}">
    <h1>Site Bloqueado</h1>
    <h4>Entre com sua senha para visualizar o site</h4>
    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
    <input type="text" name="password" placeholder="senha" required>
    <br>
    <input type="submit" value="Enviar">
</form>
</div>
</body>
</html>
