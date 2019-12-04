<table class="table table-striped">
    <thead>
        <tr>
            <th>Zutat</th>
            <th>Bio?</th>
            <th>Vegan?</th>
            <th>Vegetarisch?</th>
            <th>Glutenfrei?</th>
        </tr>
    </thead>
    <tbody>
        @foreach($zliste as $row)
        <tr>
            <td><a
                href="http://www.google.de/search?q={{ $row->ID }}"
                title="Suchen Sie nach {{ $row->Name }} im Web">{{ $row->Name }}</a>
            </td>
            <td>{!! $row->Bio ? '<i class="fa fa-check-circle-o"></i>' : '<i class="fa fa-times-circle-o"></i>' !!}</td>
            <td>{!! $row->Vegan ? '<i class="fa fa-check-circle-o"></i>' : '<i class="fa fa-times-circle-o"></i>' !!}</td>
            <td>{!! $row->Vegetarisch ? '<i class="fa fa-check-circle-o"></i>' : '<i class="fa fa-times-circle-o"></i>' !!}</td>
            <td>{!! $row->Glutenfrei ? '<i class="fa fa-check-circle-o"></i>' : '<i class="fa fa-times-circle-o"></i>' !!}</td>
        </tr>
        @endforeach
    </tbody>
</table>