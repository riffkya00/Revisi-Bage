<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Province;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Kavist\RajaOngkir\Facades\RajaOngkir;

class CheckOngkirController extends Controller
{
    public function index()
    {
        $provinces = Province::pluck('name', 'province_id');
        return view('ongkir', compact('provinces'));
    }

    public function getCities($id)
    {
        $city = City::where('province_id', $id)->pluck('name', 'city_id');
        return response()->json($city);
    }

    public function check_ongkir(Request $request)
    {
        $cost = RajaOngkir::ongkosKirim([
            'origin'        => $request->city_origin, // ID kota/kabupaten pengirim
            'destination'   => $request->city_destination, // ID kota/kabupaten tujuan
            'weight'        => $request->weight, // berat barang dalam satuan gram
            'courier'       => $request->courier // kode kurir pengiriman: ['jne', 'tiki', 'pos'] untuk starter
        ])->get();


        return response()->json($cost);
    }

}