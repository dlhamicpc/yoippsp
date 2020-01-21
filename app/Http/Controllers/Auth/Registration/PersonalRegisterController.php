<?php

namespace App\Http\Controllers\Auth\Registration;

use App\User;
use App\Http\Controllers\Controller;
use App\Models\InnerWebsite\PersonalUser;
use App\Models\Country;
use App\Models\State;
use App\Models\City;
use App\YoippspFunctions\Collection\RegistrationHelper;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;


class PersonalRegisterController extends Controller
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
    protected $redirectTo = 'http://account.yoippsp.com/pa/dashboard';

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
     * Show the application registration form/ Override the default method.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {
        $countries = Country::all();
        $states = State::all();
        $cities = City::all();

        return view('auth.register.personal', compact('countries', 'states', 'cities'));
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        //dd('validation');
        return Validator::make($data, [

            'mobile_number' => ['bail', 'required', 'string', 'mobile_number', 'min:9', 'max:10', 'unique:users'],
            
            'email'         => ['bail', 'required', 'string', 'email', 'max:191', 'unique:users'],
            
            'password'      => ['bail', 'required', 'string', 'min:8', 'confirmed'],
            
            'name'          => ['bail', 'required', 'string', 'name', 'min:2', 'max:191'],

            'father_name'   => ['bail', 'required', 'string', 'name', 'min:2', 'max:191'],

            'gender'        => ['bail', 'required', 'string', 'gender', 'min:1','max:1'],

            'date_of_birth' => ['bail', 'required', 'date', 'min:2', 'max:191'],

            'city'          => ['bail', 'required', 'string', 'min:2', 'max:191', 'exists:cities,name'],

            'state'         => ['bail', 'required', 'string', 'min:2', 'max:191', 'exists:states,name'],

            'country'       => ['bail', 'required', 'string', 'min:2', 'max:191', 'exists:countries,name'],

            'term_privacy'  => ['required'],
            
        ]);
    }

    

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create($request)
    {
        $request->merge([
            'role_id' => 5,
            'online' => 1,
            'last_login_ip' => $request->ip(),
            'last_login_device_info' => $request->server('HTTP_USER_AGENT'),
        ]);

        $request->merge([
            'mobile_number' => RegistrationHelper::fix_mobile_number($request->mobile_number)
        ]);

        $request->merge(
            ['password' => Hash::make($request->password)
        ]);

        $user =  User::create($request->all());

        $settings = '{"notifications":{"send_payment":false,"receive_payment":false,"announcements":true,"have_a_problem_with_payment":true,"service_payment":true,"special_offers":true,"new_events":true,"bill_payment_period_reached":true},"securities":{"when_login_in":false,"logged_in_with_different_device":true,"two_step_verification":false},"language":"English (United States)","time_zone":"(GMT-06:00) East Africa"}';

        $personalData = array_merge(
            $request->all([
            'name', 'father_name' , 'gender', 
            'date_of_birth', 'city', 'state',
            'country',
            ]), 
            [
                'user_id' => $user->id,
                'age' => RegistrationHelper::find_age($request->date_of_birth),
                'settings' => $settings,
            ]
        );

        $personalData['city'] = City::where('name', $personalData['city'])->get()->first()->id;
        $personalData['state'] = State::where('name', $personalData['state'])->get()->first()->id;
        $personalData['country'] = Country::where('name', $personalData['country'])->get()->first()->id;

        //dd($personalData);

        $personal = PersonalUser::create($personalData);
   
        return $user;
    }
}
