<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use  \Illuminate\Support\Facades\Validator;
use Laravel\Socialite\Facades\Socialite;


class AuthController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth:sanctum')->only('logout');
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'password_confirm'=>'required|string|min:8|same:password'
        ]);

        if($validator->fails()){
            return $this->getJsonResponse('validation',$validator->errors(),false,422);

        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;
         $data=['User' => $user,'access_token' => $token, 'token_type' => 'Bearer' ];
        return $this->getJsonResponse('success',$data);
    }

    public function login(Request $request): \Illuminate\Http\JsonResponse
    {
        if (!Auth::attempt($request->only('email', 'password')))
        {
            return Controller::getJsonResponse('invalid email or password', null, false, 422);
        }

        $user = User::query()->where('email', $request['email'])->firstOrFail();

        $token = $user->createToken('auth_token')->plainTextToken;
        $data= ['user' => $user ,'access_token' => $token, 'token_type' => 'Bearer' ];

        return $this->getJsonResponse('success',$data);

    }
    public function logout(){
        $user = auth()->user();
        $user->tokens()->delete();

        return Controller::getJsonResponse('success_logout', []);
    }
    public function faceBookRedirect($provider){
        \Log::info('redirect to '.$provider);
        return Socialite::driver($provider)->redirect();

    }
    public function facebookLogin($provider){
        try {
            \Log::info($provider);

//            return  Socialite::driver('google')->stateless()->user();
            $userSocial =Socialite::driver($provider)->stateless()->user();
//            $user = Socialite::driver($provider)->user();
            $isUser = User::where('fb_id', $userSocial->id)->first();
            \Log::info('user here too');

            \Log::info('we found in ur db'.$isUser);
            if($isUser){
                Auth::login($isUser);
                return redirect('/dashboard');
            }else{
                $createUser = User::create([
                    'name' => $userSocial->name,
                    'email' => $userSocial->email,
                    'fb_id' => $userSocial->id,
                    'password' => encrypt('123123123')
                ]);
                \Log::info($createUser);
                Auth::login($createUser);
                return redirect('/dashboard');
            }

        } catch (\Exception $exception) {
            dd($exception->getMessage());
        }
    }

}
