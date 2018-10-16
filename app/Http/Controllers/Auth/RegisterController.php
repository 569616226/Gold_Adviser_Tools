<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

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
    //    protected $redirectTo = '/admin';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //        $this->middleware('auth');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [ 'username' => 'required|string|max:255', 'email' => 'required|string|email|max:255|unique:users', 'password' => 'required|string|min:6|confirmed', 'name' => 'required|string|max:255', 'office' => 'required|string|max:255', 'tel' => 'required|numeric|max:13', 'address' => 'required|string|max:255', 'is_super' => 'required', 'fax' => 'required|numeric', 'code' => 'required|string|max:255', 'trade' => 'required|string|max:255', 'end_date' => 'required|date', 'aeo' => 'required|string|max:255', 'trade_manual' => 'required|string|max:255', 'main_trade' => 'required|string|max:255', 'pro_item_type' => 'required|string|max:255', 'capital' => 'required|string|max:255', 'company_type' => 'required|string|max:255', 'create_date' => 'required|date', ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     *
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([ 'username' => $data[ 'username' ], 'email' => $data[ 'email' ], 'password' => bcrypt($data[ 'password' ]), 'name' => $data[ 'name' ], 'office' => $data[ 'office' ], 'tel' => $data[ 'tel' ], 'address' => $data[ 'address' ], 'is_super' => $data[ 'is_super' ], 'fax' => $data[ 'fax' ], 'code' => $data[ 'code' ], 'trade' => $data[ 'trade' ], 'end_date' => $data[ 'end_date' ], 'aeo' => $data[ 'aeo' ], 'trade_manual' => $data[ 'trade_manual' ], 'main_trade' => $data[ 'main_trade' ], 'pro_item_type' => $data[ 'pro_item_type' ], 'capital' => $data[ 'capital' ], 'company_type' => $data[ 'company_type' ], 'create_date' => $data[ 'create_date' ], ]);
    }
}
