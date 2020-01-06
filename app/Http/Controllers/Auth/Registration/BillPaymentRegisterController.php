<?php

namespace App\Http\Controllers\Auth\Registration;

use App\User;
use App\Http\Controllers\Controller;
use App\Models\InnerWebsite\BillPaymentUser;
use App\Models\InnerWebsite\BillPaymentType;
use App\Models\Country;
use App\Models\State;
use App\Models\City;
use App\YoippspFunctions\Collection\RegistrationHelper;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;


class BillPaymentRegisterController extends Controller
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
    protected $redirectTo = 'http://account.yoippsp.com/bpa/dashboard';

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
        $bill_payment_types = BillPaymentType::all();

        return view('auth.register.bill_payment_provider', compact('countries', 'states', 'cities', 'bill_payment_types'));
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
                'bail', 'required', 'string', 'mobile_number', 'min:9', 'max:10', 'unique:bill_payment_users,admin_office_phone_number'
            ],
            
            'email'                     => ['bail', 'required', 'string', 'email', 'max:191', 'unique:users'],
            
            'password'                  => ['bail', 'required', 'string', 'min:8', 'confirmed'],

            'type_of_bill_payment'      => ['bail', 'required', 'integer', 'exists:bill_payment_types,id'],

            'company_name'              => ['bail', 'required', 'string', 'min:2', 'max:191'],

            'company_headquarter'       => ['bail', 'required', 'string', 'min:2', 'max:191'],
            
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
            $billPaymentUser = $this->fill_bill_payment_users_table( $request, $user->id );
            if( $billPaymentUser->id ){
                return $user;
            }
        }

        abort(500, 'UNKNOWN_ERROR');

    }

    private function fill_users_table( $request )
    {
        $user = new User();
        $user->role_id = 6;
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

    private function bill_payment_user_settings()
    {
        $settings = '{"notifications":{"announcements":true,"have_a_problem_with_payment":true,"service_payment":true},"securities":{"when_login_in":false,"logged_in_with_different_device":true,"two_step_verification":false},"language":"English (United States)","time_zone":"(GMT-06:00) East Africa"}';

        return $settings;
    }

    private function fill_bill_payment_users_table( $request, $user_id )
    {
        $billPaymentUser = new BillPaymentUser();
        $billPaymentUser->user_id = $user_id;
        $billPaymentUser->admin_name = $request->administrator_name;
        $billPaymentUser->admin_father_name = $request->administrator_father_name;
        $billPaymentUser->admin_office_phone_number = $request->secondary_mobile_number;
        $billPaymentUser->admin_gender = $request->gender;
        $billPaymentUser->admin_date_of_birth = $request->administrator_date_of_birth;
        $billPaymentUser->bill_payment_name = $request->company_name;
        $billPaymentUser->type = $request->type_of_bill_payment;
        $billPaymentUser->city = $request->city;
        $billPaymentUser->state = $request->state;
        $billPaymentUser->country = $request->country;
        $billPaymentUser->headquarter_address = $request->company_headquarter;
        $billPaymentUser->settings = (string)$this->bill_payment_user_settings();

        $billPaymentUser->save();
        return $billPaymentUser;
    }

}
