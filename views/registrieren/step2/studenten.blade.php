
<fieldset class="form-group border p-2">
    <legend class="col-form-label w-auto">Ihre Daten als Student</legend>

    <div class="row">
        <label class="col" for="studiengang">Studiengang</label>
        <div class="col">
            <select class="form-control" name="studiengang">
                @foreach($studiengaenge as $studiengang)
                    <option value="{{ $studiengang }}">{{ $studiengang }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="row">
        <label class="col" for="ablaufdatum">Matrikelnr</label>
        <div class="col">
            <input type="text" class="form-control {{ in_array('matrikelnummer', $errorfields) ? 'is-invalid' : '' }}"
                    name="matrikelnummer" value='{{ $formvals['matrikelnummer'] ?? '' }}' id="matrikelnummer" required>
        </div>
    </div>
</fieldset>