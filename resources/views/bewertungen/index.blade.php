@extends('layouts.app')

@section('content')
    <h3>Die letzten fünf Bewertungen für irgendwas (Durchschnitt: {{$avg}})</h3>
    @foreach($bewertungen as $bewertung)
    <p>{{ $bewertung->benutzer->Nutzername }}, {{ $bewertung->Bewertung }}, {{ $bewertung->Datum }}, {{ $bewertung->Bemerkung }}</p>
    @endforeach


    @if($isUser)
    <fieldset class="form-group border p-2">
        <form method="get" action="/bewertungen/schreiben">
            <button type="submit" class="btn btn-link">Bewertung schreiben</button>
        </form>
    </fieldset>
    @endif
@endsection
