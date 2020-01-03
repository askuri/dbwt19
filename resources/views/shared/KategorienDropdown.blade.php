<select class="form-control" id="sel1" name="category">
    <optgroup label="Generell">
        <option value="all">Alle zeigen</option>
    </optgroup>
    @foreach($categoryList as $category)
             @if ($category->hat === NULL)
                @if (!$loop->first)
                </optgroup>
                @endif
                <optgroup label="{{$category->Bezeichnung}}">
             @else
             <option value="{{$category->ID}}" {{$category->ID == $selectedID ? 'selected' : ''}}>{{$category->Bezeichnung}}</option>
             @endif
    @endforeach
    @if (!empty($categoryList))
        </optgroup>
    @endif
</select>
