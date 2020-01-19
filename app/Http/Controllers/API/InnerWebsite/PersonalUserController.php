<?php

namespace App\Http\Controllers\API\InnerWebsite;

use App\Models\InnerWebsite\PersonalUser;
use App\Models\InnerWebsite\UserCardLink;
use App\Models\InnerWebsite\UserBankLink;
use App\Models\InnerWebsite\UserBillPaymentLink;
use App\Models\InnerWebsite\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;


class PersonalUserController extends Controller
{

    public function __construct()
    {
        
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id = auth()->user()->id;
        
        $personalUser = PersonalUser::where( 'user_id', $user_id )->get()->first();
        $userCardLinks = UserCardLink::where( 'user_id', $user_id )->get();
        $userBankLinks = UserBankLink::where( 'user_id', $user_id )->get();
        $userBillPaymentLinks = UserBillPaymentLink::where( 'user_id', $user_id )->get();
        $transactions = Transaction::where( 'sender_id' , $user_id )
                                    ->orWhere( 'receiver_id', $user_id )
                                    ->limit(10)
                                    ->latest()
                                    ->get();

        return view(
            'innerWebsite.account.personal.layouts.master' , 
            compact( 'personalUser', 'userCardLinks' , 'userBankLinks' , 'transactions' , 'userBillPaymentLinks' )
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Registration\PersonalUser  $personalUser
     * @return \Illuminate\Http\Response
     */
    public function show(PersonalUser $personalUser)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Registration\PersonalUser  $personalUser
     * @return \Illuminate\Http\Response
     */
    public function edit(PersonalUser $personalUser)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Registration\PersonalUser  $personalUser
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PersonalUser $personalUser)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Registration\PersonalUser  $personalUser
     * @return \Illuminate\Http\Response
     */
    public function destroy(PersonalUser $personalUser)
    {
        //
    }



    //////////// HELPER FUCNTION //////////////////

    public function update_personal_details(Request $request)
    {
        $data = $this->validate_update_personal_details( $request );

        $personalUser = PersonalUser::findOrFail( auth()->user()->personal_user->id );

        if( $personalUser->update($data) ){
            return PersonalUser::findOrFail( $personalUser->id );
        }
        return 'failed';
    }

    private function validate_update_personal_details( $request )
    {
        $request['date_of_birth'] = $this->fix_date($request['date_of_birth']);

        return $request->validate([
            'name'          => ['bail', 'required', 'string', 'name', 'min:2', 'max:191'],

            'father_name'   => ['bail', 'required', 'string', 'name', 'min:2', 'max:191'],

            'date_of_birth' => ['bail', 'required', 'date'],

            'city'          => ['bail', 'required', 'integer', 'exists:cities,id'],

            'state'         => ['bail', 'required', 'integer', 'exists:states,id'],

            'country'       => ['bail', 'required', 'integer', 'exists:countries,id'],

            'address'       => ['bail', 'sometimes', 'string'],

            'home_number'   => ['bail', 'sometimes'],
        ]);

    }

    private function fix_date( $date )
    {
        if( substr_count($date,'-') == 2 ){
            $month_day_year = explode('-', $date);
            return $month_day_year[2].'-'.$month_day_year[0].'-'.$month_day_year[1];
        }
        return $date;
        
    }


    public function update_languages_time_zone(Request $request)
    {
        $data = $this->validate_update_languages_time_zone( $request );

        if( $data['account_status'] == 'delete' ){
            auth()->user()->delete();
            auth()->guard()->logout();
            abort(403);
        }

        $personalUser = PersonalUser::findOrFail( auth()->user()->personal_user->id );
        $settings = json_decode( $personalUser->settings );

        $settings->language = $data['language'];
        $settings->time_zone = $data['time_zone'];

        if( $personalUser->update( [ 'settings' => json_encode($settings) ] ) ){
            return PersonalUser::findOrFail( $personalUser->id );
        }
        return 'failed';
    }

    private function validate_update_languages_time_zone( $request )
    {
        return $request->validate([
            'language'      => ['bail', 'required', 'string', 'exists:languages,name','max:191'],

            'time_zone'     => ['bail', 'required', 'string', 'exists:time_zones,name', 'max:191'],

            'account_status' => ['bail', 'required'],
        ]);

    }

    public function update_email(Request $request)
    {
        $data = $this->validate_update_email( $request );
        $user = auth()->user();

        if( $user->update( [ 'email' => $data['email'] ] ) ){
            return auth()->user();
        }
        return 'failed';
    }

    private function validate_update_email( $request )
    {
        $id = auth()->user()->id;
        return $request->validate([
            'email'      => ['bail', 'required', 'email', 'unique:users,email,'.$id],
        ]);

    }


    public function update_mobile_number(Request $request)
    {
        $data = $this->validate_mobile_number( $request );
        $user = auth()->user();

        if( $user->update( [ 'mobile_number' => $data['mobile_number'] ] ) ){
            return auth()->user();
        }
        return 'failed';
    }

    private function validate_mobile_number( $request )
    {
        $id = auth()->user()->id;
        return $request->validate([
            'mobile_number'      => ['bail', 'required', 'mobile_number', 'unique:users,mobile_number,'.$id],
        ]);

    }

    public function update_avatar(Request $request)
    {
        try {
            $avatar_image_type = explode('/', $request->file_type )[1];
            if( !in_array( $avatar_image_type, ['png', 'jpg', 'jpeg', 'gif'] ) ){
                return 'unsupported format';
            }

            if( (int)$request->file_size > 5242880 ){
                return 'file size too large';
            }
        } catch (\Throwable $th) {
            return 'failed';
        }

        $data = $this->validate_avatar( $request );
        $user = auth()->user();

        
        if( (boolean)$data['changed'] === true ){

            
            $avatarName = $user->id.'.png';
            

            $image = \Image::make($data['avatar'])->fit(100, 100);
            $image->save(public_path('/storage/uploads/users_profile_picture/').$avatarName);

            $currentAvatar = $user->avatar;

            if( $user->update( [ 'avatar' => $avatarName ] ) ){
                return $user;
            }
            return 'failed';
        }
        else{
            return $user;
        }
    }

    private function validate_avatar( $request )
    {
        return $request->validate([
            'avatar'      => ['bail', 'sometimes'],
            'changed'     => ['bail', 'required'],
            'file_type'   => ['bail', 'required', 'string'],
        ]);
    }
    
    public function update_password(Request $request)
    {
        $data = $this->validate_password( $request );

        if( is_array($data) ) {
            return $data;
        }

        $user = auth()->user();

        if( $user->update( [ 'password' => $data ] ) ){
            return auth()->user();
        }
        
        return 'failed';
    }

    private function validate_password( $request )
    {
        $existing_password_from_database =  auth()->user()->password;

        if( !Hash::check(
                    $request->existing_password,
                    $existing_password_from_database 
        )){
            return $error_message = [
                'errors' => [
                    'existing_password' => 'The value you entered for current password is incorrect',
                ]
            ]; 
        }

        $data = $request->validate([
            'new_password'      => ['bail', 'required', 'string', 'min:8', 'confirmed']
        ]);

        return Hash::make($data['new_password']);

    }


    public function update_security_settings(Request $request)
    {
        $data = $this->change_all_to_boolean( $request );
        
        $personalUser = PersonalUser::findOrFail( auth()->user()->personal_user->id );
        $settings = json_decode( $personalUser->settings );

        $settings->securities = $data;

        if( $personalUser->update( [ 'settings' => json_encode($settings) ] ) ){
            return PersonalUser::findOrFail( $personalUser->id );
        }
        return 'failed';
    }


    public function update_notification_settings(Request $request)
    {
        $data = $this->change_all_to_boolean( $request );
        
        $personalUser = PersonalUser::findOrFail( auth()->user()->personal_user->id );
        $settings = json_decode( $personalUser->settings );

        $settings->notifications = $data;

        if( $personalUser->update( [ 'settings' => json_encode($settings) ] ) ){
            return PersonalUser::findOrFail( $personalUser->id );
        }
        return 'failed';
    }

    
    private function change_all_to_boolean( $request )
    {
        $data = $request->all();

        foreach ($data as $key => $value) {
            try {
                $data[ $key ] = (boolean) $value;
            } catch (\Throwable $th) {
                $data[ $key ] = 0;
            }
        }

        return $data;
    }


    public function update_water_payment_info(Request $request)
    {
        $data = $this->validate_water_payment_info( $request );

        $waterPaymentLink = $this->get_user_bill_payment_link( $data['water_service_provider'] );
        
        if( $this->check_if_user_linked_water_payment_info_before( $waterPaymentLink ) ) {
            $result = $waterPaymentLink->first()->update( [ 
                'bill_payment_id' => $data['water_service_provider'],
                'user_payment_identification' => $data['water_payment_identification']
            ]);

            if( $result ) {
                return $waterPaymentLink;
            }
            return 'failed';
        }
        else{

            try {
                $newWaterPaymentLink = UserBillPaymentLink::create([
                    'user_id' => auth()->user()->id,
                    'bill_payment_id' => $data['water_service_provider'],
                    'user_payment_identification' => $data['water_payment_identification'],
                    'type' => 0,
                ]);
    
                return $newWaterPaymentLink;
            } catch (\Throwable $th) {
                return 'failed';
            }
            
        }
        
    }

    private function validate_water_payment_info( $request )
    {
        return $request->validate([
            'water_service_provider'      => [
                'bail', 'required', 'integer', 'exists:bill_payment_users,id'
            ],
            'water_payment_identification'      => [
                'bail', 'required',
            ],
        ]);

    }

    private function check_if_user_linked_water_payment_info_before( $waterPaymentLink )
    {
        return $waterPaymentLink->isEmpty() ? false:true;
    }

    private function get_user_bill_payment_link(  $bill_payment_id )
    {
        return UserBillPaymentLink::where([
            'user_id' => auth()->user()->id,
            'bill_payment_id' => $bill_payment_id
        ])->get();
    }


}
