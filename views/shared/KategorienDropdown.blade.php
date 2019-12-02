<select class="form-control" id="sel1" name="category">
    <optgroup label="Generell">
        <option value="all">Alle zeigen</option>
    </optgroup>
    @foreach($categoryList as $row)
             @if ($row['hat'] === NULL)
                @if (!$loop->first)
                </optgroup>
                @endif
                <optgroup label="{{$row['Bezeichnung']}}">
             @else
             <option value="{{$row['ID']}}" {{$row['ID'] == $selectedID ? 'selected' : ''}}>{{$row['Bezeichnung']}}</option>
             @endif
    @endforeach
    @if (!empty($categoryList))
        </optgroup>
    @endif
</select>
