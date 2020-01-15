<?php

namespace App\Http\Controllers;

use App\Mahlzeit;
use Illuminate\Http\Request;
use App\Kommentar;
use Carbon\Carbon;

class DetailController extends Controller
{

    public function show(Request $request){
        $mahlzeit_obj = Mahlzeit::find($request->input('id', 1));
//        $mahlzeit = $mahlzeit_obj->get();
        
        if ($mahlzeit_obj == null) 
            die("Keine Mahlzeit mit id gefunden: " . $request->input('id', 1));

        $pictures = $mahlzeit_obj->pictures();
        $picture =  $picture[0] ?? null;

        $price = $mahlzeit_obj->priceYear()->get()[0];
        $priceForUser = NULL;
        $user_price_category = 'Studentenpreis';
        $userType = $request->session()->get('role');
        if ($userType == 'Student') {
            $user_price_category = 'Studentenpreis';
            $priceForUser = $price->Studentpreis;
        } else if ($userType == 'Gast') {
            $user_price_category = 'Gastpreis';
            $priceForUser = $price->Gastpreis;
        } else {
            $user_price_category = 'MA-Preis';
            $maPreis = 'MA-Preis';
            $priceForUser = $price->$maPreis;
        }

        return view('detail.Detail',[
            'product' => $mahlzeit_obj,
            'picture' => $picture,
            'productPrice' => $priceForUser,
            'user_price_category' => $user_price_category,
            'zutaten' => $mahlzeit_obj->ingredients()->get()
        ]);
    }
}
