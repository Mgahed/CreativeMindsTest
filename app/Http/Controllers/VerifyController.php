<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class VerifyController extends Controller
{
    public function getVerify(){
        return view('verify');
    }
    public function postVerify(Request $request){
        if($user=User::where('code',$request->code)->first()){
            $user->mobile_number_verified_at=Carbon::now();
            $user->code=null;
            $user->save();
            return response()->json([
                'status'=>true,
                'msg'=>$user
            ]);
        }
        else{
            return response()->json([
                'status'=>false,
                'msg'=>"verify code not correct try again"
            ]);
        }
    }
}
