<?php
namespace App\Models;
use Nexmo\Laravel\Facade\Nexmo;

class SendCode
{
    public static function sendCode($phone){
        $code=rand(1111,9999);
        Nexmo::message()->send([
            'to'   => $phone,
            'from' => '+201100479096',
            'text'=>'Verify code: '.$code,
        ]);
//        $nexmo=app('Nexmo\Client');
//        $nexmo->message()->send([
//            'to'=>'+880'.(int) $phone,
//            'from'=> '+8801832258644',
//            'text'=>'Verify code: '.$code,
//        ]);
        return $code;
    }

}
