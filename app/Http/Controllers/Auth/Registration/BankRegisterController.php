<?php

namespace App\Http\Controllers\Auth\Registration;

use App\User;
use App\Http\Controllers\Controller;
use App\Models\InnerWebsite\Bank;
use App\Models\InnerWebsite\BankInvitation;
use App\Models\Country;
use App\Models\State;
use App\Models\City;
use App\YoippspFunctions\Collection\RegistrationHelper;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Carbon;


class BankRegisterController extends Controller
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
    protected $redirectTo = 'http://account.yoippsp.com/bank/dashboard';

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
    public function showRegistrationForm( $id )
    {
        $invitation = BankInvitation::find($id);
        
        if( $invitation == null ) {
            abort(404);
        }
        else if( $invitation->deleted_at != null ) {
            abort(404);
        }
        else if( (int)date( 'i', Carbon::now()->timestamp - $invitation->created_at->timestamp) > 45 ) {
            abort(404);
        }

        session()->put('current_registration_id', $id);

        $countries = Country::all();
        $states = State::all();
        $cities = City::all();

        return view('auth.register.bank', compact('countries', 'states', 'cities'));
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

            'primary_mobile_number'     => [
                'bail', 'required', 'string', 'mobile_number', 'min:9', 'max:10', 'unique:users,mobile_number'
            ],

            'secondary_mobile_number'   => [
                'bail', 'required', 'string', 'mobile_number', 'min:9', 'max:10', 'unique:banks,admin_office_phone_number'
            ],
            
            'email'                     => ['bail', 'required', 'string', 'email', 'max:191', 'unique:users'],
            
            'password'                  => ['bail', 'required', 'string', 'min:8', 'confirmed'],

            'bank_name'              => ['bail', 'required', 'string', 'min:2', 'max:191'. 'unique:banks,bank_name'],

            'bank_headquarter'       => ['bail', 'required', 'string', 'min:2', 'max:191'],
            
            'administrator_name'        => ['bail', 'required', 'string', 'name', 'min:2', 'max:191'],

            'administrator_father_name' => ['bail', 'required', 'string', 'name', 'min:2', 'max:191'],

            'gender'                    => ['bail', 'required', 'string', 'gender', 'min:1','max:1'],

            'administrator_date_of_birth' => ['bail', 'required', 'date', 'min:2', 'max:191'],

            'city'                      => ['bail', 'required', 'integer', 'exists:cities,id'],

            'state'                     => ['bail', 'required', 'integer', 'exists:states,id'],

            'country'                   => ['bail', 'required', 'integer', 'exists:countries,id'],

            'term_privacy'              => ['required'],
            
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
        $user =  $this->fill_users_table( $request );

        if( $user->id ){
            $bankUser = $this->fill_banks_table( $request, $user->id );
            if( $bankUser->id ){
                BankInvitation::find( session()->get('current_registration_id') )->delete();
                session()->forget('current_registration_id');
                return $user;
            }
        }

        abort(500, 'UNKNOWN_ERROR');

    }

    private function fill_users_table( $request )
    {
        $user = new User();
        $user->role_id = 2;
        $user->mobile_number = RegistrationHelper::fix_mobile_number( $request->primary_mobile_number );
        $user->email = $request->email;
        $user->avatar = 'default.png';
        $user->password = Hash::make( $request->password );
        $user->online = 1;
        $user->last_login_ip = $request->ip();
        $user->last_login_device_info = $request->server('HTTP_USER_AGENT');
        
        $user->save();
        return $user;
    }

    private function bank_user_settings()
    {
        $settings = '{"notifications":{"announcements":true,"have_a_problem_with_payment":true,"service_payment":true},"securities":{"when_login_in":false,"logged_in_with_different_device":true,"two_step_verification":false},"language":"English (United States)","time_zone":"(GMT-06:00) East Africa"}';

        return $settings;
    }

    private function fill_banks_table( $request, $user_id )
    {
        $bankUser = new Bank();
        $bankUser->user_id = $user_id;
        $bankUser->admin_name = $request->administrator_name;
        $bankUser->admin_father_name = $request->administrator_father_name;
        $bankUser->admin_office_phone_number = $request->secondary_mobile_number;
        $bankUser->admin_gender = $request->gender;
        $bankUser->admin_date_of_birth = $request->administrator_date_of_birth;
        $bankUser->bank_name = $request->bank_name;
        $bankUser->bank_headquarter_city = $request->city;
        $bankUser->bank_headquarter_state = $request->state;
        $bankUser->bank_headquarter_country = $request->country;
        $bankUser->bank_headquarter_address = $request->bank_headquarter;
        $bankUser->settings = (string)$this->bank_user_settings();

        $bankUser->save();
        return $bankUser;
    }

}
