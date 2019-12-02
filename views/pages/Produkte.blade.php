@extends('layouts.app')

@section('title', 'Produkte')

@section('content')
<main>
    <header>
        <div class="row">
            <div class="col-3"></div>
    <div class="col"><h2>Verfügbare Speisen ({{$selectedCategoryName}})</h2></div>
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
    @include('shared.KategorienDropdown', ['categorylist' => $categoryList,
                                             'selectedID' => $selectedID
    ])

                        </div>
                        <div class="form-group">
                            <div class="checkbox">
    <label><input type="checkbox" name="avail" {{$isOnlyAvailableSelected ? 'checked' : ''}}> nur verfügbare</label>
                            </div>
                            <div class="checkbox">
    <label><input type="checkbox" name="veget" {{$isVegetSelected ? 'checked' : ''}}> nur vegetarische</label>
                            </div>
                            <div class="checkbox">
    <label><input type="checkbox" name="vegan" {{$isVeganSelected ? 'checked' : ''}}> nur vegane</label>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-light">Speisen filtern</button>
                    </form>
                </fieldset>
            </aside>
        </div>

        <!-- gallery -->
        <div class="col-7 text-center">

    @while (true)
        <div class="row"> {{-- start new row --}}

            @for ($x = 0; $x < 4; $x++)
                {{$row = mysqli_fetch_assoc($mealResult)}}
                @if (!$row)
                    <?php $product_gallery_no_more_products = true ?>
                    @break
                @endif
                <?php $product_img_class = $row['Vorrat'] > 0 ? 'w-100' : 'w-100 img-thumbnail' ?>
                <?php $product_link_class = $row['Vorrat'] > 0 ? '' : 'btn-link disabled'?>

                <div class="col-3 thumbnail">
                    <img alt="{{$row['Alt-Text']}}" class="{{$product_img_class}}"
                        src="data:image/jpeg;base64,{{base64_encode($row["Binärdaten"])}}">
                    <div class="caption">
                        {{$row['Name']}}<br>
                        <a href="Detail.php?id={{$row['ID']}}" class="{{$product_link_class}}">Details</a>
                    </div>
                </div>
            @endfor
        </div>
        @break ($product_gallery_no_more_products)
    @endwhile

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
