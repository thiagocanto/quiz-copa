<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;


class FlagsController extends Controller
{
    private $searchCode;

    function index(){
        return view('bandeiras');
    }

    function show($step){
        $countries = json_decode(File::get('../resources/json/countries.json'));

        $correctCountryIndex = array_rand($countries, 1);
        $randomCountriesKeys = array_rand($countries, 3);
        while($this->isCountryChosen($randomCountriesKeys, $correctCountryIndex)) $randomCountriesKeys = array_rand($countries, 3);

        $country = $countries[$correctCountryIndex];
        $possibleCountries = [];
        foreach($randomCountriesKeys as $randomCountryKey) $possibleCountries[] = $countries[$randomCountryKey];
        $possibleCountries[] = $country;

        shuffle($possibleCountries);
        session(['q'.$step => ['q'=>$country->code,'a'=>null]]);

        return view('bandeiras', compact('country', 'possibleCountries','step'));
    }

    function update(Request $request, $step){
        $questionAndAnswer = $request->session()->get('q'.$step);
        $questionAndAnswer['a'] = $request->input('guessedCountry');
        
        $request->session()->put('q'.$step, $questionAndAnswer);
        
        if ($step < 5){
            return redirect()->action('FlagsController@show', ['step' => ++$step]);
        } else {
            return redirect()->action('FlagsController@final');
        }
    }

    function final(Request $request){
        $fullAnswers = [];

        for($i = 1; $i <= 5; $i++) $answers[$i] = $request->session()->get('q'.$i);

        $correctCount = 0;
        foreach($answers as $key => $answer){
            if ($answer['q'] == $answer['a']) $correctCount++;

            $fullAnswers[$key]['q'] = $this->searchCountryByCode($answer['q']);
            $fullAnswers[$key]['a'] = $this->searchCountryByCode($answer['a']);

            $fullAnswers[$key]['v'] = $fullAnswers[$key]['q']->code == $fullAnswers[$key]['a']->code;
        }

        return view('placar', compact('fullAnswers', 'correctCount'));
    }

    private function isCountryChosen($list, $index){
        return in_array($index,$list);
    }

    private function searchCountryByCode($code){
        $this->searchCode = $code;
        $countries = json_decode(File::get('../resources/json/countries.json'));

        $found = array_filter($countries, function($country){
            return ($this->searchCode == $country->code);
        });
        return array_pop($found);
    }
}
