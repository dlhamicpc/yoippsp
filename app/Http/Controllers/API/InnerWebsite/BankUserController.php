<?php

namespace App\Http\Controllers\API\InnerWebsite;

use App\YoippspFunctions\Collection\RegistrationHelper;
use App\Models\InnerWebsite\Transaction;
use App\Models\InnerWebsite\UserCardLink;
use App\Models\InnerWebsite\UserBankLink;
use App\Models\InnerWebsite\Bank;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class BankUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id = auth()->user()->id;
        
        $bankUser = Bank::where( 'user_id', $user_id )->get()->first();
        $transactions = Transaction::where( 'sender_id' , $user_id )
                                    ->orWhere( 'receiver_id', $user_id )
                                    ->limit(10)
                                    ->latest()
                                    ->get();
                                    

        return view(
            'innerWebsite.account.bank.layouts.master' , 
            compact( 'bankUser', 'transactions' )
        );
    }

  


    //////////// HELPER FUCNTION //////////////////

    public function update_bank_user_details(Request $request)
    {
        $data = $this->validate_update_bank_user_details( $request );

        $bankUser = auth()->user()->bank_user;

        $data = $this->set_bank_user_details( $data );

        if( $bankUser->update($data) ){
            return $bankUser;
        }
        return 'failed';
    }

    private function set_bank_user_details( $data )  
    {
        $newData = [];
        $newData['admin_name'] = $data['administrator_name'];
        $newData['admin_father_name'] = $data['administrator_father_name'];
        $newData['admin_date_of_birth'] = $data['date_of_birth'];
        $newData['bank_headquarter_city'] = $data['city'];
        $newData['bank_headquarter_state'] = $data['state'];
        $newData['bank_headquarter_country'] = $data['country'];
        $newData['headquarter_address'] = $data['headquarter_address'];
        $newData['bank_name'] = $data['bank_name'];
        return $newData;
    }

    private function validate_update_bank_user_details( $request )
    {
        $request['date_of_birth'] = $this->fix_date($request['date_of_birth']);

        return $request->validate([
            'administrator_name'          => ['bail', 'required', 'string', 'name', 'min:2', 'max:191'],

            'administrator_father_name'   => ['bail', 'required', 'string', 'name', 'min:2', 'max:191'],

            'date_of_birth' => ['bail', 'required', 'date'],

            'city'          => ['bail', 'required', 'integer', 'exists:cities,id'],

            'state'         => ['bail', 'required', 'integer', 'exists:states,id'],

            'country'       => ['bail', 'required', 'integer', 'exists:countries,id'],

            'headquarter_address'       => ['bail', 'required', 'string'],

            'bank_name'       => ['bail', 'required', 'string', 'unique:banks,bank_name,'.auth()->user()->bank_user->id],
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

        $bankUser = auth()->user()->bank_user;
        $settings = json_decode( $bankUser->settings );

        $settings->language = $data['language'];
        $settings->time_zone = $data['time_zone'];

        if( $bankUser->update( [ 'settings' => json_encode($settings) ] ) ){
            return $bankUser;
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

        $bankUser = auth()->user()->bank_user;

        $primary_mobile_number = RegistrationHelper::fix_mobile_number( $data['primary_mobile_number'] );
        $secondary_mobile_number = RegistrationHelper::fix_mobile_number( $data['secondary_mobile_number'] );

        if( $user->update( [ 'mobile_number' => $primary_mobile_number ] ) ){
            if( $bankUser->update([ 'admin_office_phone_number' => $secondary_mobile_number ]) ){
                return [
                    'user' => $user,
                    'userDetails' => $bankUser
                ];
            }
            return 'failed';
        }
        return 'failed';
    }

    private function validate_mobile_number( $request )
    {
        $id = auth()->user()->id;
        $bankUserID = auth()->user()->bank_user->id;
        return $request->validate([
            'primary_mobile_number'      => [
                'bail', 'required', 'mobile_number', 'unique:users,mobile_number,'.$id
            ],
            'secondary_mobile_number'      => [
                'bail', 'required', 'mobile_number', 'unique:banks,admin_office_phone_number,'.$bankUserID
            ],
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


    public function update_bank_logo(Request $request)
    {
        try {
            $bank_logo_image_type = explode('/', $request->file_type )[1];
            if( !in_array( $bank_logo_image_type, ['png', 'jpg', 'jpeg', 'gif'] ) ){
                return 'unsupported format';
            }

            if( (int)$request->file_size > 5242880 ){
                return 'file size too large';
            }
        } catch (\Throwable $th) {
            return 'failed';
        }

        $data = $this->validate_bank_logo( $request );
        $bankUser = auth()->user()->bank_user;

        
        if( (boolean)$data['changed'] === true ){

            $bankLogoName = explode( ' ', strtolower($bankUser->bank_name));

            $bankLogoName = join('_' , $bankLogoName);

            $bankLogoName = $bankLogoName.'.png';
            

            $image = \Image::make($data['bank_logo'])->fit(100, 100);
            $image->save(public_path('/storage/uploads/banks_logo/').$bankLogoName);

            $currentbank_logo = $bankUser->bank_logo;

            if( $bankUser->update( [ 'bank_logo' => $bankLogoName ] ) ){
                return $bankUser;
            }
            return 'failed';
        }
        else{
            return $bankUser;
        }
    }

    private function validate_bank_logo( $request )
    {
        return $request->validate([
            'bank_logo'      => ['bail', 'sometimes'],
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
        
        $bankUser = auth()->user()->bank_user;
        $settings = json_decode( $bankUser->settings );

        $settings->securities = $data;

        if( $bankUser->update( [ 'settings' => json_encode($settings) ] ) ){
            return $bankUser;
        }
        return 'failed';
    }


    public function update_notification_settings(Request $request)
    {
        $data = $this->change_all_to_boolean( $request );
        
        $bankUser = auth()->user()->bank_user;
        $settings = json_decode( $bankUser->settings );

        $settings->notifications = $data;

        if( $bankUser->update( [ 'settings' => json_encode($settings) ] ) ){
            return $bankUser;
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


  


    public function customer_list_card()
    {

        $user_id = auth()->user()->id;
        
        $bankUser = auth()->user()->bank_user;
        $transactions = Transaction::where( 'sender_id' , $user_id )
                                    ->orWhere( 'receiver_id', $user_id )
                                    ->limit(10)
                                    ->latest()
                                    ->get();

        $customers = UserCardLink::where('bank_id' , $bankUser->id)->latest()->paginate(10);

        return view(
            'innerWebsite.account.bank.pages.customer_list_card.index' , 
            compact( 'bankUser', 'transactions', 'customers' )
        );
    }

    public function customer_list_account()
    {

        $user_id = auth()->user()->id;
        
        $bankUser = auth()->user()->bank_user;
        $transactions = Transaction::where( 'sender_id' , $user_id )
                                    ->orWhere( 'receiver_id', $user_id )
                                    ->limit(10)
                                    ->latest()
                                    ->get();
                                    

        $customers = UserBankLink::where('bank_id' , $bankUser->id)->latest()->paginate(10);

        //dd($customers);

        return view(
            'innerWebsite.account.bank.pages.customer_list_account.index' , 
            compact( 'bankUser', 'transactions', 'customers' )
        );
    }


}
