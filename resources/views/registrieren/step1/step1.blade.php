
<fieldset class="form-group border p-2">
    <legend class="col-form-label w-auto">Ihre Registrierung</legend>

    <div class="row">
        <label class="col" for="nickname">Nickname</label>
        <div class="col">
            <input type="text" class="form-control" name="nickname" value='{{ $formvals['nickname'] ?? '' }}' id="nickname" required>
        </div>
    </div>

    <div class="row">
        <label class="col" for="pw1">Passwort</label>
        <div class="col">
            <input type="password"
                   class="form-control {{ in_array('pw1', $errorfields) ? 'is-invalid' : '' }}"
                   name="pw1" value='{{ $formvals['pw1'] ?? '' }}' id="pw1" required>
        </div>
    </div>

    <div class="row">
        <div class="col-6"></div>
        <div class="col-6">
            <p>Das Passwort muss mindestens 10 Zeichen lang sein und mindestens eine Ziffer und ein Sonderzeichen enthalten.</p>
        </div>
    </div>

    <div class="row">
        <label class="col" for="pw2">Passwort</label>
        <div class="col">
            <input type="password"
                   class="form-control {{ in_array('pw2', $errorfields) ? 'is-invalid' : '' }}"
                   name="pw2" value='{{ $formvals['pw2'] ?? '' }}' id="pw2" required>
        </div>
    </div>

    <div class="row">
        <label class="col">Was tun Sie?</label>
        <div class="col">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="gast" id="gast" value="checked" {{ $formvals['gast'] ?? '' }}>
                <label class="form-check-label" for="gast">Ich bin Gast</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="mitarbeiter" id="mitarbeiter" value="checked" {{ $formvals['mitarbeiter'] ?? '' }}>
                <label class="form-check-label" for="mitarbeiter">Ich arbeite an der FH</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="student" id="student" value="checked" {{ $formvals['student'] ?? '' }}>
                <label class="form-check-label" for="student">Ich studiere an der FH</label>
            </div>
        </div>
    </div>
</fieldset>