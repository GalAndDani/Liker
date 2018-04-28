<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use App\Jobs\SendVerificationEmail;
use Illuminate\Support\Str;

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
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('verify');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'country'    => 'required|string|max:255',
            'email'      => 'required|string|email|max:255|unique:users',
            'password'   => 'required|string|min:6|confirmed',
            'day'        => 'required',
            'month'      => 'required',
            'year'       => 'required',
            'gender'     => 'required',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'first_name'  => $data['first_name'],
            'last_name'   => $data['last_name'],
            'country'     => $data['country'],
            'email'       => $data['email'],
            'gender'      => $data['gender'],
            'birthday'    => $data['year'] . '-' . $data['month'] . '-' . $data['day'],
            'ref_id'      => $this->generateRefId(),
            'ref_user_id' => $data['ref_user_id'],
            'password'    => bcrypt($data['password']),
            'email_token' => base64_encode($data['email'])
        ]);
    }

    /**
     * Handle a registration request for the application.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();
        event(new Registered($user = $this->create($request->all())));
        dispatch(new SendVerificationEmail($user));
        return view('email/verification');
    }

    /**
     * Handle a registration request for the application.
     *
     * @param $token
     * @return \Illuminate\Http\Response
     */
    public function verify($token)
    {
        $user = User::where('email_token', $token)->first();
        if($user) {
            $user->verified = 1;
        }
        if ($user->ref_user_id) {
            $ref = User::where('ref_id', $user->ref_user_id)->first();
            if($ref) {
                $ref->points = $ref->points + 300;
                $ref->save();
            }
        }
        if ($user->save()) {
            return view('email/emailconfirm', [ 'user' => $user ]);
        } else {
            dd('error');
        }
    }

    public function generateRefId()
    {
        do {
            $ref = Str::random(10);
        } while (User::where("ref_id", "=", $ref)->first() instanceof User);

        return $ref;
    }
}
