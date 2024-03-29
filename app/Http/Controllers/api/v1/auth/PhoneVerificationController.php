<?php

namespace App\Http\Controllers\api\v1\auth;

use App\CPU\Helpers;
use App\CPU\SMS_module;
use App\Http\Controllers\Controller;
use App\Model\PhoneOrEmailVerification;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use function App\CPU\translate;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Crypt;

class PhoneVerificationController extends Controller
{
    public function check_phone(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'temporary_token' => 'required',
            'phone' => 'required|min:11|max:14'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        }

        $user = User::where(['temporary_token' => $request->temporary_token])->first();

        if (isset($user) == false) {
            return response()->json([
                'message' => translate('temporary_token_mismatch'),
            ], 200);
        }

        // $token = rand(1000, 9999);
        $token = '1234';
        DB::table('phone_or_email_verifications')->insert([
            'phone_or_email' => $request['phone'],
            'token' => $token,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $response = SMS_module::send($request['phone'], $token);
        return response()->json([
            'message' => $response,
            'token' => 'active'
        ], 200);
    }

    public function verify_phone(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required',
            'temporary_token' => 'required',
            'otp' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        }

        $verify = PhoneOrEmailVerification::where(['phone_or_email' => $request['phone'], 'token' => $request['otp']])->first();

        if (isset($verify)) {
            try {
                $user = User::where(['temporary_token' => $request['temporary_token']])->first();
                $user->phone = $request['phone'];
                $user->is_phone_verified = 1;

                $user->save();
                $verify->delete();
            } catch (\Exception $exception) {
                return response()->json([
                    'message' => translate('temporary_token_mismatch'),
                ], 200);
            }
          
            $token = $user->createToken('LaravelAuthApp')->accessToken;
            $client = new Client();
            $response = $client->request('post','https://trendservices.ust.center/public/api/register',[
                'form_params'=>[
                    "name"=>$user->f_name,
                    "email"=>$user->email,
                    "phone_number"=>$user->phone,
                    "password"=>$user->password_service,
                    "phone_verified_at"=>"2022/5/5"
                ]
                ]);
                $body = $response->getBody();
                $data = json_decode($body);
                 $var_service='';
                if( $data->success == true )
                {
    
                   $var_service = $data->data;
                }
            return response()->json([
                
                [
                    'token' => $token,
                    'message' => translate('otp_verified'),
                    
                ],
                    
                    $var_service


                
            ], 200);
        }

        return response()->json(['errors' => [
            ['code' => 'token', 'message' => translate('otp_not_found')]
        ]], 404);
    }
}
