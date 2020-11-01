<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

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

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
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
            'fname' => ['required', 'string', 'max:255'],
            'lname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    public function register(Request $request)
    {
        $exist_user=User::where(['email'=>$request->email])->first();
        if($exist_user==null)
        {
            $user = new User();
            $user->fname = $request->fname;
            $user->lname = $request->lname;
            $user->org_name = $request->org_name;
            $user->street = $request->street;
            $user->city = $request->city;
            $user->street = $request->street;
            $user->mobile = $request->mobile;
            $user->expire_date = $request->expire_date;
            $user->license_key = $request->license_key;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->save();
            return redirect('home')->with(session()->flash('error', 'Something went wrong!'));


            
        }
        else{
            return redirect()->back()->with(session()->flash('error', 'User already exists,please try another email!'));
        }
    }
}
