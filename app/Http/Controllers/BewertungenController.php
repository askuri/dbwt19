<?php

namespace App\Http\Controllers;

use App\Mahlzeit;
use Illuminate\Http\Request;
use App\Kommentar;
use Carbon\Carbon;

class BewertungenController extends Controller
{
    public function index(Request $request) {
        if($request->id == null){
            $request->id = 1;
        }

        $mahlzeit_object = Mahlzeit::find($request->id);
        $bewertungen_object =
            $mahlzeit_object->comments()->orderBy('id', 'desc')->limit(5);
        $bewertungen = $bewertungen_object->get();
        $avg = $bewertungen_object->avg('Bewertung');

        $isUser = $request->session()->get('role') == 'Student';
        return view('bewertungen.index', [
            'bewertungen' => $bewertungen,
            'avg' => $avg,
            'isUser' => $isUser,
            'mahlzeitName' => $mahlzeit_object->Name,
            'mahlzeitID' => $mahlzeit_object->ID
        ]);
    }

    public function create(Request $request) {
        if($request->id == null){
          $request->id = 1;
        }
        $mahlzeit = Mahlzeit::find($request->id);

        return view('bewertungen.create_single',
            ['mahlzeitName' => $mahlzeit->Name,
                'mahlzeitID' => $mahlzeit->ID]);
    }

    public function store(Request $request) {
        if ($request->session()->get('role') != 'Student') {
            die ('nicht als student angemeldet');
        }
        $kommentar = new Kommentar();
        $kommentar->MahlzeitenID = $request->id;
        $kommentar->StudentenID = $request->session()->get('userid');
        $kommentar->Bemerkung = $request->input('bemerkung', '');
        $kommentar->Bewertung = $request->input('bewertung', 1);
        $kommentar->Datum = Carbon::now('Europe/Berlin');
        $kommentar->save();

        return back()->withInput();
    }
}
