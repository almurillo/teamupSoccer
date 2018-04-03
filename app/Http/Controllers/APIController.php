<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;

class APIController extends Controller
{

   public function getCityList(Request $request){

    $cities = DB::table('cities')
    ->select('city')
    ->distinct()
    ->where('state_code','=',$request->state_code)
    ->orderBy('city')
    ->get()
    ->toArray();

    return response()->json($cities);

    }
}
