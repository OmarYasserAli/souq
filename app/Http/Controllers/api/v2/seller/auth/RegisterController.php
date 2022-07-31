<?php

namespace App\Http\Controllers\api\v2\seller\auth;

use App\CPU\Helpers;
use App\CPU\ImageManager;
use App\Http\Controllers\Controller;
use App\Model\Seller;
use App\Model\Shop;
use App\Model\Country;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required|unique:sellers',
            'shop_address' => 'required',
            'f_name' => 'required',
            'l_name' => 'required',
            'city_id' => 'required',
            'country_id' => 'required',
            'shop_name' => 'required',
            'phone' => 'required',
            'password' => 'required|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        }

        DB::transaction(function ($r) use ($request) {
            $seller = new Seller();
            $seller->f_name = $request->f_name;
            $seller->l_name = $request->l_name;
            $seller->phone = $request->phone;
            $seller->email = $request->email;
            $seller->image = ImageManager::upload('seller/', 'png', $request->file('image'));
            $seller->password = bcrypt($request->password);
            $seller->status =  $request->status == 'approved'?'approved': "pending";
            $seller->country_id=$request->country_id;
            $seller->government_id=$request->city_id;
            $seller->save();

            $shop = new Shop();
            $shop->seller_id = $seller->id;
            $shop->name = $request->shop_name;
            $shop->address = $request->shop_address;
            $shop->contact = $request->phone;
            $shop->image = ImageManager::upload('shop/', 'png', $request->file('logo'));
            $shop->banner = ImageManager::upload('shop/banner/', 'png', $request->file('banner'));
            $shop->country_id=$request->country_id;
            $shop->government_id=$request->city_id;
            $shop->save();

            DB::table('seller_wallets')->insert([
                'seller_id' => $seller['id'],
                'withdrawn' => 0,
                'commission_given' => 0,
                'total_earning' => 0,
                'pending_withdraw' => 0,
                'delivery_charge_earned' => 0,
                'collected_cash' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

        });
        if($request->status == 'approved'){
            return response()->json(['message' => "create Seller Successfully"], 200);
        }else{
            return response()->json(['message' => "create Seller Successfully we will approved you"], 200);
        }



    }
}
