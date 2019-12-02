@php
$status = $_SESSION['loginstatus'] ?? '';
@endphp

@if($status == 'authenticated')
    <p>Hallo {{ $_SESSION['user'] }}, Sie sind angemeldet als
        <strong>{{ $_SESSION['role'] }}</strong></p>
    <a href='Auth.php?logout=true' class='btn btn-light'>Abmelden</a>
@elseif($status == 'fail')
    <p class="text-danger">Das hat nicht geklappt! Bitte versuchen Sie es erneut.</p>
    
    <fieldset class="form-group border p-2">
        <legend class="col-form-label w-auto">Login</legend>
        <form method="post" action="Auth.php">
            <div class="form-group">
                <input type="text" class="form-control form-control-sm"
                       name="user" class="bg-danger" id="inputUser"placeholder="Benutzer">
            </div>
            <div class="form-group">
                <input type="password" class="form-control form-control-sm"
                       name="pass" class="bg-danger" id="inputPassword" placeholder="******">
            </div>

            <button type="submit" class="btn btn-link">Anmelden</button>
        </form>
    </fieldset>
@else 
    <fieldset class="form-group border p-2">
        <legend class="col-form-label w-auto">Login</legend>
        <form method="post" action="Auth.php">
            <div class="form-group">
                <input type="text" class="form-control form-control-sm"
                       name="user" id="inputUser" name="user" placeholder="Benutzer">
            </div>
            <div class="form-group">
                <input type="password" class="form-control form-control-sm"
                       name="pass" id="inputPassword" name="pass" placeholder="******">
            </div>

            <button type="submit" class="btn btn-link">Anmelden</button>
        </form>
    </fieldset>
@endif