<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use  Session;


class AvaliableFlightsController extends Controller
{
    private function checkExpDate(){
        $is_valid = false;
        $expires_in=Session::get('expires_in');
        $subTime=$expires_in-time();
        if($subTime>0){
            $is_valid = true;
        }else{
            $is_valid = false;
        }      
        
        return $is_valid;
    }

    private function getAccessToken(){
        $client = new \GuzzleHttp\Client();
        $access_token='VmpFNmNIQXpNSFl5TWpoaU5tbG1kVFl3WmpwRVJWWkRSVTVVUlZJNlJWaFU6UjI4M1prMDJSbW89';
        $response = $client->request('POST', 'https://api-crt.cert.havail.sabre.com/v2/auth/token', [
            'headers' => [
                'Authorization' => 'Basic '.$access_token,
                'Content-Type' => 'application/x-www-form-urlencoded',
                'grant_type'=>'client_credentials'
                ]
        ]);
        $response = $response->getBody()->getContents();
        $response=json_decode($response);
        $expires_in=time() + $response->expires_in;
        $access_token=$response->access_token;
        Session::put('expires_in',$expires_in);
        Session::put('access_token',$access_token);
        return $access_token;
    }

    public function search(Request $request){
        if($this->checkExpDate()){
            $access_token=Session::get('access_token');
        }else{
            $access_token=$this->getAccessToken();
        }
        $request->validate([
            'departuredate' => 'required|date|after:'.now(),
            'returndate' => 'required|date|after_or_equal:'.$request->departuredate,
        ]);
        $origin=$request->origin;
        $destination=$request->destination;
        $departuredate=$request->departuredate;
        $returndate=$request->returndate;
        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', 'https://api-crt.cert.havail.sabre.com/v1/shop/flights?origin='.$origin.'&destination='.$destination.'&departuredate='.$departuredate.'&returndate='.$returndate , [
            'headers' => ['Authorization' => 'Bearer '.$access_token,'X-Originating-IP' => $request->ip()]
        ]);
        if($response->getStatusCode() == 200 ){
        $response = $response->getBody()->getContents();
        $res=json_decode($response);
        $PricedItineraries=$res->PricedItineraries;
         return view('searchFlightsResult',
         compact('PricedItineraries','origin','destination'));
        }
        else{
            return view('searchFlights');
        }
    
    }
}
