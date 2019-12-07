@extends('layouts.app')

@section('title', 'Registrieren')

@section('content')
    <main>
        <div class="row col-6">
            @if(!empty($errormsgs))
                <p>Es gab Fehler beim Bearbeiten Ihrer Anfrage:</p>
                <ul>
                    @foreach($errormsgs as $msg)
                        <li>{{$msg}}</li>
                    @endforeach
                </ul>
            @endif
            
            <form action="#" method="POST">
                <input type="hidden" name="step" value="{{ $formvals['step'] }}">

                @switch($formvals['step'])
                    @case(1)
                        @include('registrieren.step1.step1')
                        <div class="row">
                            <div class="col-6">
                                <button type="submit" class="btn btn-light">Registrierung Fortsetzen</button>
                            </div>
                        </div>
                        @break
                    @case(2)
                        <input type="hidden" name="nickname" value="{{ $formvals['nickname'] }}">
                        <input type="hidden" name="pw1" value="{{ $formvals['pw1'] }}">
                        <input type="hidden" name="pw2" value="{{ $formvals['pw2'] }}">
                        <input type="hidden" name="gast" value="{{ $formvals['gast'] ?? '' }}">
                        <input type="hidden" name="mitarbeiter" value="{{ $formvals['mitarbeiter'] ?? '' }}">
                        <input type="hidden" name="student" value="{{ $formvals['student'] ?? '' }}">
                        
                        @include('registrieren.step2.benutzer')
                        @if($formvals['gast'] ?? '')
                            @include('registrieren.step2.gaeste')
                        @elseif(($formvals['mitarbeiter'] ?? '') || ($formvals['student'] ?? ''))
                            @include('registrieren.step2.fh_angehoerige')
                            @if($formvals['mitarbeiter'] ?? '') 
                                @include('registrieren.step2.mitarbeiter')
                            @else
                                @include('registrieren.step2.studenten')
                            @endif
                        @endif
                        <div class="row">
                            <div class="col-6">
                                <button type="submit" class="btn btn-light">Senden</button>
                            </div>
                        </div>
                        @break
                    @case(3)
                        @include('registrieren.step3.success')
                @endswitch
            </form>
        </div>
    </main>
@endsection

