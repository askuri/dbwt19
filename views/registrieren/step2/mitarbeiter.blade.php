
<fieldset class="form-group border p-2">
    <legend class="col-form-label w-auto">Ihre Mitarbeiterdaten</legend>
    
    <div class="row">
        <label class="col" for="buero">Büro</label>
        <div class="col">
            <input type="text" class="form-control" name="buero" value='{{ $formvals['buero'] ?? '' }}' id="buero">
        </div>
    </div>
    <div class="row">
        <label class="col" for="telefon">Telefon</label>
        <div class="col">
            <input type="tel" class="form-control" name="telefon" value='{{ $formvals['telefon'] ?? '' }}' id="telefon">
        </div>
    </div>
</fieldset>