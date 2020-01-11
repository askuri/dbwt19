<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Kommentar;
use Carbon\Carbon;

class BewertungenController extends Controller
{
    public function index(Request $request) {
        $bewertungen_object = Kommentar::orderBy('id', 'desc')->limit(5);
        $bewertungen = $bewertungen_object->get();
        $avg = $bewertungen_object->avg('Bewertung');

        $isUser = $request->session()->get('role') == 'Student';
        return view('bewertungen.index', [
            'bewertungen' => $bewertungen,
            'avg' => $avg,
            'isUser' => $isUser,
        ]);
    }

    public function create() {
        return view('bewertungen.create');
    }

    public function store(Request $request) {
        if ($request->session()->get('role') != 'Student') {
            die ('nicht als student angemeldet');
        }
        $kommentar = new Kommentar();
        $kommentar->MahlzeitenID = 1;
        $kommentar->StudentenID = $request->session()->get('userid');
        $kommentar->Bemerkung = $request->input('bemerkung', '');
        $kommentar->Bewertung = $request->input('bewertung', 1);
        $kommentar->Datum = Carbon::now('Europe/Berlin');
        $kommentar->save();

        return redirect('/bewertungen');
    }
}
