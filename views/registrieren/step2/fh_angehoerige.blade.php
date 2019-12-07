
<fieldset class="form-group border p-2">
    <legend class="col-form-label w-auto">Ihr Fachbereich</legend>
    
    <div class="row">
        <div class="col-6">
            <p>Welchen Fachbereichen gehören Sie an?</p>
        </div>
        <div class="col-6">
            <select class="form-control" name="fachbereiche[]" multiple>
                @foreach($fachbereiche as $fb)
                    <option value="{{ $fb['ID'] }}">{{ $fb['Name'] }}</option>
                @endforeach
            </select>
        </div>
    </div>
</fieldset>