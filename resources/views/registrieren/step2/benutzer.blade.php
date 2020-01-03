
<fieldset class="form-group border p-2">
    <legend class="col-form-label w-auto">Ihre Benutzerdaten</legend>
    
    <div class="row">
        <label class="col" for="vorname">Vorname</label>
        <div class="col">
            <input type="text" class="form-control" name="vorname" value='{{ $formvals['vorname'] ?? '' }}' id="vorname" required>
        </div>
    </div>
    <div class="row">
        <label class="col" for="nachname">Nachname</label>
        <div class="col">
            <input type="text" class="form-control" name="nachname" value='{{ $formvals['nachname'] ?? '' }}' id="nachname" required>
        </div>
    </div>
    <div class="row">
        <label class="col" for="email">E-Mail</label>
        <div class="col">
            <input type="email" class="form-control {{ in_array('email', $errorfields) ? 'is-invalid' : '' }}"
                   name="email" value='{{ $formvals['email'] ?? '' }}' id="email" required>
        </div>
    </div>
    <div class="row">
        <label class="col" for="geburtsdatum">Geburtsdatum</label>
        <div class="col">
            <input type="date" class="form-control" name="geburtsdatum" value='{{ $formvals['geburtsdatum'] ?? '' }}' id="geburtsdatum" required>
        </div>
    </div>
</fieldset>