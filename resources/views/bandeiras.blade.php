<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        @if (isset($step))
        <title>Perginta {{$step}} - Quiz da Copa!</title>
        @else
        <title>Quiz da Copa!</title>
        @endif

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            <div class="content">
                <h1 class="title text-center m-b-md">Quiz</h1>
                <h3 class="text-center">Complete o quiz de 4 questões para saber o quanto você sabe sobre as bandeiras do mundo!</h3>
                @if(!isset($country))
                <a  class="btn btn-primary start-button" href="{{ route('bandeiras.show', ['step'=>1]) }}">Começar</a>
                @else
                <div class="flag-container">
                    <img src="//flags.fmcdn.net/data/flags/w580/{{ strtolower($country->code) }}.png" alt="">
                </div>
                <form method="POST" class="flag-responses" action="{{ route('bandeiras.update', ['step'=>$step]) }}">
                    @method('PUT')
                    @csrf
                    @foreach($possibleCountries as $possibleCountry)
                    <button class="flag-response btn btn-light" name="guessedCountry" value="{{$possibleCountry->code}}">{{$possibleCountry->name}}</button>
                    @endforeach
                </form>
                @endif
            </div>
        </div>
    </body>
</html>
