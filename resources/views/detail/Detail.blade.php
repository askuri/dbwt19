@extends('layouts.app')

{{--@section('title', 'Zutaten')--}}

@section('content')
    <main>
        <header>
            <div class="row">
                <div class="col-3"></div> 
                <div class="col"><h2>Details für "{{ $product->Name }}"</h2></div>
            </div>
        </header>

        <div class="row">
            <!-- login -->
            <div class="col-3">
                <aside>
                    @include('login.Login')
                </aside>
            </div>

            <!-- detail image -->
            <div class="col-7">
                @if($picture)
                <img alt="{{ $picture->AltText }}" class="w-100"
                     src="data:image/jpeg;base64,{{ base64_encode($picture->Binärdaten) }}">
                @endif
            </div>

            <!-- price and order -->
            <div class="col-2 text-right">
                <div class="row h-50">
                    <div class="col">
                        <p class="mb-0"><strong>{{ $user_price_category }}</strong></p>
                        <p class="mb-0 h3"><strong>{{ $productPrice }} €</strong></p>
                    </div>
                </div>
                <div class="row align-items-end h-50">
                    <div class="col">
                        <a href="#" class="shadow border border-secondary btn btn-light"><i class="fa fa-cutlery"></i> Vorbestellen</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- sidebar -->
            <div class="col-3">
                <aside>
                    <p>
                        Melden Sie sich jetzt an, um die wirklich viel günstigeren Preise
                        für Mitarbeiter oder Studenten zu sehen
                    </p>
                </aside>
            </div>

            <!-- content box with nav header -->
            <div class="col-7">
                <!-- page selector -->
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item" id="beschreibung-tab">
                        <a class="nav-link active" data-toggle="tab" href="#beschreibung" role="tab" aria-controls="beschreibung" aria-selected="true">Beschreibung</a>
                    </li>
                    <li class="nav-item" id="zutaten-tab">
                        <a class="nav-link" data-toggle="tab" href="#zutaten" role="tab" aria-controls="zutaten" aria-selected="false">Zutaten</a>
                    </li>
                    <li class="nav-item" id="bewertung-tab">
                        <a class="nav-link" data-toggle="tab" href="#bewertungen" role="tab" aria-controls="bewertungen" aria-selected="false">Bewertungen</a>
                    </li>
                </ul>

                <!-- below the page selector -->
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="beschreibung" role="tabpanel" aria-labelledby="beschreibung-tab">
                        {{ $product->Beschreibung }}
                    </div>
                    <div class="tab-pane fade" id="zutaten" role="tabpanel" aria-labelledby="zutaten-tab">
                        @include('shared.ZutatenTabelle', ['zliste' => $zutaten])
                    </div>

                    <!-- Mahlzeit-Bewertung -->
                    <div class="tab-pane fade" id="bewertungen" role="tabpanel" aria-labelledby="bewertung-tab">
                        @include('bewertungen.create', [ 'mahlzeitName' => $product->Name, 'mahlzeitID' => $product->ID])
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
