<div>
    <h2>Importation Failed - {{config('app.name')}}</h2>
    <br>
    <br>
    <ul>
        <li>
            <strong>Id:</strong>
            {{$importation->id}}
        </li>
        <li>
            <strong>Stages:</strong>
            {{$importation->getStagesFormated()}}
        </li>
        <li>
            <strong>Start:</strong>
            {{$importation->getStartFormated()}}
        </li>
        <li>
            <strong>End:</strong>
            {{$importation->getEndFormated()}}
        </li>
        <li>
            <strong>Last Completed:</strong>
            {{$lastCompleted}}
        </li>

    </ul>

</div>
