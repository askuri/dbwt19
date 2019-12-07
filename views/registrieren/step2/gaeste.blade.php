
<fieldset class="form-group border p-2">
    <legend class="col-form-label w-auto">Ihre Daten als Gast</legend>

    <div class="row">
        <label class="col" for="grund">Grund</label>
        <div class="col">
            <input type="text" class="form-control" name="grund" value='{{ $formvals['grund'] ?? '' }}' id="grund" required>
        </div>
    </div>
    <div class="row">
        <label class="col" for="ablaufdatum">Ablaufdatum</label>
        <div class="col">
            <input type="date" class="form-control" name="ablaufdatum" value='{{ $formvals['ablaufdatum'] ?? '' }}' id="ablaufdatum" required>
        </div>
    </div>
</fieldset>