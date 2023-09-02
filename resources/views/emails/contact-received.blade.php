<div>
    <h2>Novo Contato - {{config('app.name')}}</h2>
    <br>
    <br>
    <ul>
        <li>
            <strong>Nome:</strong>
            {{$contact->name}}
        </li>
        <li>
            <strong>E-mail:</strong>
            {{$contact->email}}
        </li>
        <li>
            <strong>Telefone:</strong>
            {{$contact->phone}}
        </li>
        <li>
            <strong>Mensagem:</strong>
            {{$contact->message}}
        </li>

    </ul>

</div>
