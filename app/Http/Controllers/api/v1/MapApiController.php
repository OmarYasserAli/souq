<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\BusinessSetting;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use App\CPU\Helpers;
use App\Model\Country;
use App\Model\Government;
class MapApiController extends Controller
{
    public function place_api_autocomplete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'search_text' => 'required',
        ]);
        if ($validator->errors()->count() > 0) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        }
        $api_key = Helpers::get_business_settings('map_api_key');
        $api_key = 'AIzaSyDfnUAEQtTSJ1ca2GZKF0_MPc16K6MixlI';
        $response = Http::get('https://maps.googleapis.com/maps/api/place/autocomplete/json?input=' . $request['search_text'] . '&key=' . $api_key);
        return $response->json();
    }

    public function distance_api(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'origin_lat' => 'required',
            'origin_lng' => 'required',
            'destination_lat' => 'required',
            'destination_lng' => 'required',
        ]);
        if ($validator->errors()->count() > 0) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        }
        $api_key = Helpers::get_business_settings('map_api_key');
        $response = Http::get('https://maps.googleapis.com/maps/api/distancematrix/json?origins=' . $request['origin_lat'] . ',' . $request['origin_lng'] . '&destinations=' . $request['destination_lat'] . ',' . $request['destination_lng'] . '&key=' . $api_key);
        return $response->json();
    }

    public function place_api_details(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'placeid' => 'required',
        ]);
        if ($validator->errors()->count() > 0) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        }
        $api_key = Helpers::get_business_settings('map_api_key');
        $response = Http::get('https://maps.googleapis.com/maps/api/place/details/json?placeid=' . $request['placeid'] . '&key=' . $api_key);
        return $response->json();
    }

    public function geocode_api(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'lat' => 'required',
            'lng' => 'required',
        ]);
        if ($validator->errors()->count() > 0) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        }
        $api_key = Helpers::get_business_settings('map_api_key');
        $api_key = 'AIzaSyDfnUAEQtTSJ1ca2GZKF0_MPc16K6MixlI';
        $response = Http::get('https://maps.googleapis.com/maps/api/geocode/json?latlng=' . $request->lat . ',' . $request->lng . '&key=' . $api_key.'&region=EN&language=us_en&sensor=false');
        $res = (($response->json()));
        $country_code = ($res['results'][0]['address_components'][3]['short_name']);

    $data_of_country = [];
        foreach ($res['results'][1]['address_components'] as $comp) {
            //loop through each component in ['address_components']
            foreach ($comp['types'] as $currType){
                //for every type in the current component, check if it = the check
                if($currType == 'administrative_area_level_1'){

                    $data_of_country['long_name'] = $comp['long_name'];
                    //Do whatever with the component, print longname, whatever you need
                    //You can add $comp into another array to have an array of 'administrative_area_level_1' types
                }
                if($currType == 'country'){
                    $data_of_country['short_name'] = $comp['short_name'];

                    //Do whatever with the component, print longname, whatever you need
                    //You can add $comp into another array to have an array of 'administrative_area_level_1' types
                }
            }
        }
          $country_of_long_name = Country::where("code",$data_of_country['short_name'])->first();

           $get_mohafza = explode(" ",$data_of_country['long_name']);
           if (count($get_mohafza) == 3 ){
               $get_mohafza = $get_mohafza[1];
           }else{
               $get_mohafza = $get_mohafza[0];

           }
        $goverment_of_long_name = Government::where("country_id",$country_of_long_name->id)->where("name",$get_mohafza)->first();
        return response()->json([
            'status' => 200,
            'message' => 'success',         
            'goverment' => $goverment_of_long_name,
            'country' => $country_of_long_name,
            
        ]);
    }
}
