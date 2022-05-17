<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Model\HelpTopic;
use App\Model\Country;
use App\Model\Government;
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


   

}
