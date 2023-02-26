<?php

namespace App\Http\Controllers\Normaluser;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\Normaluser;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    use AuthenticatesUsers {                                //追記
        logout as performLogout;                            //追記
    }
    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/normaluser/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:normaluser');
    }

    protected function guard()                  //追記
   {                                           //追記
       return Auth::guard('normalusers');            //追記
   }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
     protected function validator(array $data)
     {
         return Validator::make($data, [
             'name' => ['required', 'string', 'max:255'],
             'userid' => ['required', 'string','min:8','max:8'],     //修正
             'password' => ['required', 'string', 'min:6', 'confirmed'],
         ]);
     }


     protected function create(array $data)
     {
         return Normaluser::create([                  //修正
             'name' => $data['name'],
             'userid' => $data['userid'],
             'password' => Hash::make($data['password']),
         ]);
     }
 }
