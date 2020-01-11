@extends('layouts.app')

@section('content')
<h1>Mahlzeit bewerten</h1>

<form action="/bewertungen/schreiben" method="post">
    @csrf
    <div class="form-group row">
        <label for="rating_rating" class="col-6 col-form-label text-right">Bewertung</label>
        <div class="col-6">
            <input type="number" min="0" max="5" name="bewertung" value="1" id="rating_rating" step="1">
        </div>
    </div>
    <div class="form-group row">
        <label for="bewertung_bemerkung" class="col-6 col-form-label text-right">Bemerkung</label>
        <div class="col-6">
            <textarea cols="15" id="bewertung_bemerkung" name="bemerkung" rows="4">Geben Sie eine Bemerkung ein, wenn Sie möchten...</textarea>
        </div>
    </div>
    <div class="form-group row">
        <div class="col-6"></div>
        <div class="col-6">
            <button type="submit" class="btn btn-link">Bewertung absenden <i class="fa fa-chevron-right"></i></button>
        </div>
    </div>
</form>
@endsection