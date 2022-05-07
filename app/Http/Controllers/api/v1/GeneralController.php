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
       $governments= Government::all('id','name');
        return response()->json($governments,200);
    }
    public function all_countries(){
    	$countries= Country::all('name','code');
        return response()->json($countries,200);
    }


   

}
