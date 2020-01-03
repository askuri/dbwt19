@extends('layouts.app')

@section('title', 'Zutaten')

@section('content')
    <h2>Zutatenliste ({{ $num_rows }})</h2>
    <main>
        @include('shared.ZutatenTabelle', ['zliste' => $zliste])
    </main>
@endsection

