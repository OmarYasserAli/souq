<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Model\HelpTopic;
use App\Model\Country;
use App\Model\Government;
use Illuminate\Http\Request;

class GeneralController extends Controller
{
    public function faq(){
        return response()->json(HelpTopic::orderBy('ranking')->get(),200);
    }
    public function all_cities(){

       if(isset(request()->country_id))
         $governments=Government::where('country_id', request()->country_id)->select('id','name')->get();
      elseif(isset(request()->country_code))
        {
            $country= Country::where('code',request()->country_code)->first();
          $governments=Government::where('country_id', $country->id)->select('id','name')->get();  
        } 
        else
            $governments= Government::all('id','name');
       
        return response()->json(
            [
                'status'=>'200',
                'count'=>$governments->count(),
                'data'=>$governments,
            ]);
    }
    public function all_countries(){
    	$countries= Country::all('name','code','id');
        return response()->json([
            'status'=>200,
            'count'=>$countries->count(),
            'data'=>$countries
        ]);
    }

    public function getCitiesFromCountry(Request $request){
        $country=Country::where('code',$request->country_code)->first();
        $data['governments'] = Government::where("country_id",$country->id)
                    ->get(["name","id"]);
        return response()->json($data);
    }

    public function getMapLocation(Request $request){
        $country=Country::where('code',$request->country_code)->first();
        $data['governments'] = Government::where("country_id",$country->id)
                    ->get(["name","id"]);
        return response()->json($data);
    }

    public function getLocationFromMap(){
        if(!isset(request()->latlng)) return false;
        $url="https://maps.googleapis.com/maps/api/geocode/json?
        latlng="+request()->latlng+"&sensor=true
        &key=AIzaSyDfnUAEQtTSJ1ca2GZKF0_MPc16K6MixlI&language=pt_BR";
        $client = new GuzzleHttp\Client();
        $res = $client->get($url);
        echo $res->getStatusCode(); // 200
        echo $res->getBody();
    }


   

}
