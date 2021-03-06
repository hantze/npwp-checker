<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NpwpController extends Controller
{
    public function check(Request $request, $npwp){

        $urlNpwp    = 'https://sse3.pajak.go.id/cekWsDataWp';

        $data       = array("npwp" => $npwp);
        $dataJson   = json_encode($data);

        $ch         = curl_init();
        curl_setopt($ch, CURLOPT_URL, $urlNpwp);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataJson);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Cookie: TSPD_101='.$request->token
        ));
        $result         = curl_exec($ch);
        $objectResult   = json_decode($result);

        if($objectResult->status == 1)
            return response()->json($objectResult, 200);
        else
            return response()->json($objectResult, 400);
    }
}
