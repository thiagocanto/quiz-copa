<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Quiz da Copa! - Resultado</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            <div class="content">
                <h1 class="title text-center m-b-md">Quiz</h1>
                <h4 class="text-center">Você acertou {{$correctCount}} de 5.<br />Cheque abaixo quais!</h4>
                <table class="text-center">
                    <tr>
                    <th>Pergunta</th>
                    <th>Resposta</th>
                    </tr>
                @foreach ($fullAnswers as $step => $res)
                    <tr>
                        <td>{{$step}}. <span class="badge-pill badge-light">{{$res['q']->name}}</span></td>
                        <td><span class="badge-pill badge-{{ $res['v']?'success':'danger' }}">{{$res['a']->name}}</span></td>
                    </tr>
                @endforeach
                </table>

                <a href="{{ route('bandeiras.show',['step'=>1]) }}" class="start-button btn btn-primary">Jogar novamente</a>
            </div>
        </div>
    </body>
</html>
