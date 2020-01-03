@extends('layouts.app')

@section('content')
    <h3>Die letzten Bewertungen für irgendwas</h3>
    @foreach($bewertungen as $bewertung)
    <p>{{ $bewertung->benutzer->Nutzername }}, {{ $bewertung->Bewertung }}, {{ $bewertung->Datum }}, {{ $bewertung->Bemerkung }}</p>
    @endforeach
@endsection