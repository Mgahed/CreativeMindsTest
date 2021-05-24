<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
//use Twilio\Rest\Client;
use App\Models\SendCode;

class UserController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('api', ['except' => ['login', 'register']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mobile_number' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if (!$token = auth('api')->attempt($validator->validated())) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        return $this->createNewToken($token);
    }

    /**
     * Register a User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required|string|',
            'mobile_number' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(array(
                "status" => false,
                "errors" => $validator->errors()
            ), 400);
        }

//        /* Get credentials from .env */
//        $token = env("TWILIO_AUTH_TOKEN", 'AC4c2f8d4c005da102a31f0830514e6520');
//        $twilio_sid = env("TWILIO_SID", '3ddded5387db76639323c0bd3ab93cd6');
//        $twilio_verify_sid = env("TWILIO_VERIFY_SID", 'VAc0fdea2f1cf2103fa33760a30cf71445');
//        $twilio = new Client($twilio_sid, $token);
//        $twilio->verify->v2->services($twilio_verify_sid)
//            ->verifications
//            ->create($request->mobile_number, "sms");
        $user = User::create(array_merge(
            $validator->validated(),
            ['password' => bcrypt($request->password)]
        ));

        if ($user) {
            $user->code=SendCode::sendCode($user->mobile_number);
            $user->save();
        }

        return response()->json([
            'status' => true,
            'message' => 'User successfully registered',
            'user' => $user
        ], 201);
    }

//    protected function verify(Request $request)
//    {
//        $data = $request->validate([
//            'verification_code' => ['required', 'numeric'],
//            'mobile_number' => ['required', 'string'],
//        ]);
//        /* Get credentials from .env */
//        $token = env("TWILIO_AUTH_TOKEN", 'AC4c2f8d4c005da102a31f0830514e6520');
//        $twilio_sid = env("TWILIO_SID", '3ddded5387db76639323c0bd3ab93cd6');
//        $twilio_verify_sid = env("TWILIO_VERIFY_SID", 'VAc0fdea2f1cf2103fa33760a30cf71445');
//        $twilio = new Client($twilio_sid, $token);
//        $verification = $twilio->verify->v2->services($twilio_verify_sid)
//            ->verificationChecks
//            ->create($data['verification_code'], array('to' => $data['mobile_number']));
//        if ($verification->valid) {
//            $user = tap(User::where('mobile_number', $data['mobile_number']))->update(['isVerified' => true]);
//            /* Authenticate user */
//            return response()->json([
//                'status' => true,
//                'message' => 'User mobile_number verified',
//                'user' => $user
//            ], 201);
//        }
//        return response()->json([
//            'status' => false,
//            'message' => 'User mobile_number not verified',
//        ]);
//    }


    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth('api')->logout();

        return response()->json(['message' => 'User successfully signed out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->createNewToken(auth('api')->refresh());
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function userProfile()
    {
        return response()->json(auth('api')->user());
    }

    /**
     * Get the token array structure.
     *
     * @param string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function createNewToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60,
            'user' => auth('api')->user()
        ]);
    }
}
