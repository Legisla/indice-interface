@extends('voyager::master')


@section('content')

    <p style="padding: 20px">
        Dados atualizados em {{$lastImportationEnd}} - <a target="_self" href="{{route('all-data-csv')}}">baixar csv todos os dados</a>
        - <a target="_self" href="{{route('indicators-data-csv')}}">baixar csv com dados de processamento de indicadores</a>
    </p>
    <hr>

    <table class="all-data-table">
        @foreach($tableData as $row)
            <tr class="{{$row != reset($tableData)?'tr-hover':''}}">
                @foreach($row as  $value)
                    @if(!empty($value['link']))
                        <td class="{!!$value['class'] !!}">
                            <a href="{!!$value['link']!!}" target="_blank">{!!$value['text']!!}</a>
                        </td>
                    @else
                        <td class="{!!$value['class'] !!}">{!!$value['text']!!}</td>
                    @endif
                @endforeach
            </tr>
        @endforeach

    </table>

    <style>
        .all-data-table {
            border-collapse: collapse;
            width: 100%;
            text-align: center;
        }

        .thm {
            background-color: #000000;
            color: #ffffff;
            padding: 5px;
        }

        .tha {
            background-color: #f8991c;
            color: white;
            padding: 5px;
        }

        .thi {
            background-color: #86500a;
            color: white;
            padding: 5px;
        }

        .ths {
            background-color: #fa2567;
            color: white;
            padding: 5px;
        }

        .tds {
            color: #fa2567;
            padding: 5px;
        }

        .tdm {
            background-color: #000000;
            color: #ffffff;
            padding: 3px;
        }

        .tdm a {
            background-color: #000000;
            color: #ffffff;
            padding: 3px;
        }

        .tda {
            font-weight: bold;
            padding: 3px;
        }

        .td {
            padding: 3px;
        }

        tr:nth-child(odd) {
            background-color: #fcf0f3
        }

        .tr-hover:hover td {
            background-color: #fa2567;
            color: white !important;
        }

        .tr-hover:hover td a{
            background-color: #fa2567;
            color: white !important;
        }

        .outlier {
            font-weight: bold;
            color: #04ceff !important;
        }


    </style>

@endsection
