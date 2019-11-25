@extends('layouts.app')

@section('title', 'Produkte')

@section('content')
<main>
    <header>
        <div class="row">
            <div class="col-3"></div>
            <div class="col"><h2>Verfügbare Speisen (Bestseller)</h2></div>
        </div>
    </header>

    <div class="row">
        <div class="col-3">
            <!-- Filter -->
            <aside>
                <fieldset class="form-group border p-2">
                    <legend class="col-form-label w-auto">Speiseliste filtern</legend>
                    <form method="get" action="#">
                        <div class="form-group">
    @include('includes.KategorienDropdown', ['categorylist' => $categoryList,
                                             'selectedID' => $selectedID
    ])

                        </div>
                        <div class="form-group">
                            <div class="checkbox">
                                <label><input type="checkbox" name="avail"> nur verfügbare</label>
                            </div>
                            <div class="checkbox">
                                <label><input type="checkbox" name="veget"> nur vegetarische</label>
                            </div>
                            <div class="checkbox">
                                <label><input type="checkbox" name="vegan"> nur vegane</label>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-light">Speisen filtern</button>
                    </form>
                </fieldset>
            </aside>
        </div>

        <!-- gallery -->
        <div class="col-7 text-center">
        @php
            
            while (true) {
                echo '<div class="row">'; // start new row
                
                for ($x = 0; $x < 4; $x++) {
                    
                    $row = mysqli_fetch_assoc($mealResult);
                    if (!$row) {
                        echo '</div>'; // end row
                        break 2; // break 2 loops
                    }
                    echo '<div class="col-3 thumbnail">
                        <img alt="'.$row['Alt-Text'].'" class="w-100"
                            src="data:image/jpeg;base64,'.base64_encode($row["Binärdaten"]).'">
                        <div class="caption">
                            '.$row['Name'].'<br>
                            <a href="Detail.php?id='.$row['ID'].'">Details</a>
                        </div>
                    </div>';
                }
                
                echo '</div>'; // end row
            }
    @endphp
           
            <!-- Beispiele
            <div class="row">
                <div class="col-3 thumbnail">
                    <img alt="Curry Wok" class="w-100" src="https://dummyimage.com/200x200/0008a6/fff.png">
                    <div class="caption">
                        Curry Wok<br>
                        <a href="Detail.html">Details</a>
                    </div>
                </div>
                <div class="col-3 thumbnail">
                    <img alt="Food" class="img-thumbnail w-100" src="https://dummyimage.com/200x200/0008a6/fff.png">
                    <div class="caption text-muted">
                        Bratrolle<br>
                        <a href="Detail.html" class="btn-link disabled">Details</a>
                    </div>
                </div>
            </div>-->
        </div>
    </div>
</main>
@endsection
