<?php

namespace App\Http\Controllers\api\v1;

use App\CPU\Helpers;
use App\CPU\ProductManager;
use App\Http\Controllers\Controller;
use App\Model\Seller;
use App\Model\Shop;
use Illuminate\Http\Request;
use App\Model\OrderDetail;
use App\Model\Product;
use App\Model\Review;

class SellerController extends Controller
{
    /**/
    public function get_seller_info(Request $request)
    {   
        $data=[];
        $seller = Seller::with(['shop'])->where(['id' => $request['seller_id']])->first(['id', 'f_name', 'l_name', 'phone', 'image','facebook','active_facebook','twitter','active_twitter','instagram','active_instagram','tiktok','active_tiktok','active_whatsapp']);
        
        $product_ids = Product::where(['added_by' => 'seller', 'user_id' => $request['seller_id']])->pluck('id')->toArray();
                
        $avg_rating = Review::whereIn('product_id', $product_ids)->avg('rating');
        $total_review = Review::whereIn('product_id', $product_ids)->count();
        $total_order = OrderDetail::whereIn('product_id', $product_ids)->groupBy('order_id')->count();
        
        $data['seller']= $seller;
        $data['avg_rating']= round($avg_rating);
        $data['total_review']=  $total_review;
        $data['total_order']= $total_order;
        $data['total_product']= count($product_ids);

        return response()->json($data, 200);
    }

    public function get_seller_products($seller_id, Request $request)
    {
        $data = ProductManager::get_seller_products($seller_id, $request['limit'], $request['offset']);
        $data['products'] = Helpers::product_data_formatting($data['products'], true);
        return response()->json($data, 200);
    }

    public function get_top_sellers()
    {
        $top_sellers = Shop::whereHas('seller',function ($query){return $query->approved();})
                            ->take(15)->get();
        $top_sellers = $top_sellers->map(function($data){
            $data['seller_id'] = (int)$data['seller_id'];
            return $data;
        });
        return response()->json($top_sellers, 200);
    }

    public function get_all_sellers()
    {
        $top_sellers = Shop::whereHas('seller',function ($query){return $query->approved();})->get();
        return response()->json($top_sellers, 200);
    }
}
