<?php

namespace App\Http\Controllers\Seller;

use App\CPU\ImageManager;
use App\Http\Controllers\Controller;
use App\Model\Seller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use function App\CPU\translate;

class ProfileController extends Controller
{
    public function view()
    {
        $data = Seller::where('id', auth('seller')->id())->first();
        return view('seller-views.profile.view', compact('data'));
    }

    public function edit($id)
    {
        if (auth('seller')->id() != $id) {
            Toastr::warning(translate('you_can_not_change_others_profile'));
            return back();
        }
        $data = Seller::where('id', auth('seller')->id())->first();
        return view('seller-views.profile.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $this->validate(request(), [
            'instagram' => 
                array(
                    'regex:/(instagram.com|instagr.am|instagr.com)/i','nullable'
                ),
                'twitter' => 
                array(
                    'regex:/http(?:s)?:\/\/(?:www\.)?twitter\.com\/([a-zA-Z0-9_]+)/','nullable'
                ),
                'facebook' => 
                array(
                    'regex:/(?:(?:http|https):\/\/)?(?:www.)?facebook.com\/(?:(?:\w)*#!\/)?(?:pages\/)?(?:[?\w\-]*\/)?(?:profile.php\?id=(?=\d.*))?([\w\-]*)?/','nullable'
                ),
                'tiktok' => 
                array(
                    'regex:/((?:(?:http|https):\/\/)?(?:www.)?tiktok.com)\/([a-zA-Z0-9_@]+)/','nullable'
                ),
                'website_url' =>  array(
                    'url','nullable'
                ),
                'map_location' =>  array(
                  //  'regex:/^https?\:\/\/(www\.|maps\.)?google(\.[a-z]+){1,2}\/maps\/?\?([^&]+&)*(ll=-?[0-9]{1,2}\.[0-9]+,-?[0-9]{1,2}\.[0-9]+|q=[^&]+)+($|&)/','nullable'
                ),
                
        ]);
       
        $seller = Seller::find(auth('seller')->id());
        $seller->f_name = $request->f_name;
        $seller->l_name = $request->l_name;
        $seller->phone = $request->phone;
        
        $seller->bio = $request->bio;
        $seller->facebook = $request->facebook;
        $seller->twitter = $request->twitter;
        $seller->instagram = $request->instagram;
        $seller->website_url = $request->website_url;
        $seller->map_location = $request->map_location;
        $seller->tiktok = $request->tiktok;
        (isset($request->active_facebook) && $request->active_facebook =='on' )? $seller->active_facebook = 1 :$seller->active_facebook=0;
        (isset($request->active_twitter) && $request->active_twitter =='on' )? $seller->active_twitter = 1 :$seller->active_twitter=0;
        (isset($request->active_tiktok) && $request->active_tiktok =='on' )? $seller->active_tiktok = 1 :$seller->active_tiktok=0;
        (isset($request->active_instagram) && $request->active_instagram =='on' )? $seller->active_instagram = 1 :$seller->active_instagram=0;
        (isset($request->active_whatsapp) && $request->active_whatsapp =='on' )? $seller->active_whatsapp = 1 :$seller->active_whatsapp=0;
        (isset($request->active_website_url) && $request->active_website_url =='on' )? $seller->active_website_url = 1 :$seller->active_website_url=0;
        (isset($request->active_map_location) && $request->active_map_location =='on' )? $seller->active_map_location = 1 :$seller->active_map_location=0;

        if ($request->image) {
            $seller->image = ImageManager::update('seller/', $seller->image, 'png', $request->file('image'));
        }
        $seller->save();

        Toastr::info('Profile updated successfully!');
        return back();
    }

    public function settings_password_update(Request $request)
    {
        $request->validate([
            'password' => 'required|same:confirm_password|min:8',
            'confirm_password' => 'required',
        ]);

        $seller = Seller::find(auth('seller')->id());
        $seller->password = bcrypt($request['password']);
        $seller->save();
        Toastr::success('Seller password updated successfully!');
        return back();
    }

    public function bank_update(Request $request, $id)
    {
        $bank = Seller::find(auth('seller')->id());
        $bank->bank_name = $request->bank_name;
        $bank->branch = $request->branch;
        $bank->holder_name = $request->holder_name;
        $bank->account_no = $request->account_no;
        $bank->save();
        Toastr::success('Bank Info updated');
        return redirect()->route('seller.profile.view');
    }

    public function bank_edit($id)
    {
        if (auth('seller')->id() != $id) {
            Toastr::warning(translate('you_can_not_change_others_info'));
            return back();
        }
        $data = Seller::where('id', auth('seller')->id())->first();
        return view('seller-views.profile.bankEdit', compact('data'));
    }

}
