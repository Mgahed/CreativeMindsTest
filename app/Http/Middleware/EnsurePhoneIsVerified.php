<?php

namespace App\Http\Middleware;

use App\Models\SendCode;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;

class EnsurePhoneIsVerified
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (auth('api')->user() && auth('api')->user()->mobile_number_verified_at == null) {
//            $user = User::find(auth('api')->user()->id);
//            $code=SendCode::sendCode($user->mobile_number);
//            $user->update([
//                'code'=>$code
//            ]);
            return response()->json([
                'status' => false,
                'msg' => 'Verification needed',
            ]);
        }

        return $next($request);
    }
}
