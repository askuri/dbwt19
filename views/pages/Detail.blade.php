@extends('layouts.app')

@section('title', 'Zutaten')

@section('content')
    <main>
        <header>
            <div class="row">
                <div class="col-3"></div> 
                <div class="col"><h2>Details für "{{ $product['Name'] }}"</h2></div>
            </div>
        </header>

        <div class="row">
            <!-- login -->
            <div class="col-3">
                <aside>
                    @include('includes.Login')
                </aside>
            </div>

            <!-- detail image -->
            <div class="col-7">
                <img alt="{{ $product["Alt-Text"] }}" class="w-100" src="data:image/jpeg;base64,{{ base64_encode($product["Binärdaten"]) }}">
            </div>

            <!-- price and order -->
            <div class="col-2 text-right">
                <div class="row h-50">
                    <div class="col">
                        <p class="mb-0"><strong>{{ $_SESSION['role'] ?? 'Gast' }}</strong>-Preis</p>
                        <p class="mb-0 h3"><strong>{{ $product[$user_price_category] }} €</strong></p>
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
                        {{ $product['Beschreibung'] }}
                    </div>
                    <div class="tab-pane fade" id="zutaten" role="tabpanel" aria-labelledby="zutaten-tab">
                        @include('includes.ZutatenTabelle', ['zliste' => $zutaten])
                    </div>

                    <!-- Mahlzeit-Bewertung -->
                    <div class="tab-pane fade" id="bewertungen" role="tabpanel" aria-labelledby="bewertung-tab">
                        <form action="http://bc5.m2c-lab.fh-aachen.de/form.php" method="post">
                        <input type="hidden"  name="matrikel" value="3188047"> 
                        <input type="hidden"  name="kontrolle" value="Kip"> 
                        <div class="form-group row justify-content-center">
                            <label for="bewertung_mahlzeit" class="col-6 col-form-label text-right">Mahlzeit</label>
                            <div class="col-6">
                                <select id="bewertung_mahlzeit" class="form-control" name="mahlzeit">
                                    <option selected value="Falafel">Falafel</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row justify-content-center">
                            <label for="bewertung_user" class="col-6 col-form-label text-right">Benutzername</label>
                            <div class="col-6">
                                <input required type="text" name="benutzer" class="form-control" id="bewertung_user" placeholder="Max Mustermann">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="rating_rating" class="col-6 col-form-label text-right">Bewertung</label>
                            <div class="col-6">
                                <input type="number" min="0" max="5" name="bewertung" id="rating_rating"  step="1">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="bewertung_bemerkung" class="col-6 col-form-label text-right">Bemerkung</label>
                            <div class="col-6">
                                <textarea cols="15" id="bewertung_bemerkung" name="Bemerkung" rows="4">
                                    Geben Sie eine Bemerkung ein, wenn Sie möchten...
                                </textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-6"></div>
                            <div class="col-6">
                            <button type="submit" class="btn btn-link">Bewertung absenden <i class="fa fa-chevron-right"></i></button>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection