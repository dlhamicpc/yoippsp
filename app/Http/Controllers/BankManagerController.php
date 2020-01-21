<?php

namespace App\Http\Controllers;

use App\Models\InnerWebsite\BankManager;
use App\Models\InnerWebsite\Transaction;
use App\User;
use App\Models\Country;
use App\Models\City;
use App\Models\State;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class BankManagerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id = auth()->user()->id;
        
        $bankUser = auth()->user()->bank_user;
        $transactions = Transaction::where( 'sender_id' , $user_id )
                                    ->orWhere( 'receiver_id', $user_id )
                                    ->limit(10)
                                    ->latest()
                                    ->get();

        $bankManagers = BankManager::latest()->paginate(10);                            

        return view(
            'innerWebsite.account.bank.pages.bank_manager.index' , 
            compact( 'bankUser', 'transactions', 'bankManagers' )
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user_id = auth()->user()->id;
        
        $bankUser = auth()->user()->bank_user;
        $transactions = Transaction::where( 'sender_id' , $user_id )
                                    ->orWhere( 'receiver_id', $user_id )
                                    ->limit(10)
                                    ->latest()
                                    ->get();
               

        return view(
            'innerWebsite.account.bank.pages.bank_manager.create' , 
            compact( 'bankUser', 'transactions' )
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $this->validate_data_create( $request );
        $data = $this->add_extra_data( $data );

        

        $user = User::create($data);
        $bankManager = BankManager::create( $this->data_for_bank_manager( $user, $data ) );


        return redirect('/bank/bank_managers')->with('message', 'Bank manager created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\InnerWebsite\BankManager  $bankManager
     * @return \Illuminate\Http\Response
     */
    public function show(BankManager $bankManager)
    {
        $user_id = auth()->user()->id;
        $bankUser = auth()->user()->bank_user;
        $transactions = Transaction::where( 'sender_id' , $user_id )
                                    ->orWhere( 'receiver_id', $user_id )
                                    ->limit(10)
                                    ->latest()
                                    ->get();               

        return view(
            'innerWebsite.account.bank.pages.bank_manager.show' , 
            compact( 'bankUser', 'transactions', 'bankManager')
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\InnerWebsite\BankManager  $bankManager
     * @return \Illuminate\Http\Response
     */
    public function edit(BankManager $bankManager)
    {
        $user_id = auth()->user()->id;
        $bankUser = auth()->user()->bank_user;
        $transactions = Transaction::where( 'sender_id' , $user_id )
                                    ->orWhere( 'receiver_id', $user_id )
                                    ->limit(10)
                                    ->latest()
                                    ->get();               

        return view(
            'innerWebsite.account.bank.pages.bank_manager.edit' , 
            compact( 'bankUser', 'transactions', 'bankManager')
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\InnerWebsite\BankManager  $bankManager
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BankManager $bankManager)
    {
        $data = $this->validate_data_edit( $request, $bankManager->user->id );

        $bankManager->update( [
            'name' => $data['bank_manager_name'], 
            'father_name' => $data['bank_manager_father_name'],
            'bank_branch' => $data['branch_name']
        ]);

        $userUpdateData = [
            'email' => $data['email'], 
            'mobile_number' => $data['mobile_number'],
        ];

        if( isset($data['password']) && $data['password'] != null ) {
            $userUpdateData['password'] = Hash::make( $data['password'] );
        }

        $bankManager->user->update( $userUpdateData );

        return redirect('/bank/bank_managers')->with('message', 'Bank manager updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\InnerWebsite\BankManager  $bankManager
     * @return \Illuminate\Http\Response
     */
    public function destroy(BankManager $bankManager)
    {
        $bankManager->delete();
        return redirect('/bank/bank_managers')->with('message', 'Bank manager delete successfully.');
    }

    private function validate_data_create( $request )
    {
        return $request->validate([

            'email'                          => ['bail', 'required', 'string', 'email', 'max:191', 'unique:users'],

            'mobile_number'                  => [
                'bail', 'required', 'string', 'mobile_number', 'min:9', 'max:10', 'unique:users'
            ],

            'bank_manager_name'              => ['bail', 'required', 'string', 'name', 'min:2', 'max:191'],

            'bank_manager_father_name'       => ['bail', 'required', 'string', 'name', 'min:2', 'max:191'],

            'password'                       => ['bail', 'required', 'string', 'min:8', 'confirmed'],

            'branch_name'        => ['bail', 'required', 'string', 'name', 'min:2', 'max:191'],
        ]);
    }

    
    private function validate_data_edit( $request, $bankManagerID )
    {
        $validatioinRule = [
            'email'                          => ['bail', 'required', 'string', 'email', 'max:191', 'unique:users,email,'.$bankManagerID],

            'mobile_number'                  => [
                'bail', 'required', 'string', 'mobile_number', 'min:9', 'max:10', 'unique:users,mobile_number,'.$bankManagerID
            ],

            'bank_manager_name'              => ['bail', 'required', 'string', 'name', 'min:2', 'max:191'],

            'bank_manager_father_name'       => ['bail', 'required', 'string', 'name', 'min:2', 'max:191'],

            'branch_name'        => ['bail', 'required', 'string', 'name', 'min:2', 'max:191'],
        ];

        if( isset( $request->password ) ) {
            $validatioinRule['password'] = ['bail', 'sometimes', 'string' ,'min:8', 'confirmed'];
        }

        return $request->validate( $validatioinRule );
    }

    private function add_extra_data( $data )
    {
        $data['role_id'] = 8;
        $data['password'] = Hash::make($data['password']);
        $data['last_login_ip'] = request()->ip();
        $data['last_login_device_info'] = request()->server('REMOTE_ADDR');

        return $data;
    }

    private function data_for_bank_manager( $user, $data )
    {
        $bankManager['user_id'] = $user->id;
        $bankManager['bank_id'] = auth()->user()->bank_user->id;
        $bankManager['name'] = $data['bank_manager_name'];
        $bankManager['father_name'] = $data['bank_manager_father_name'];
        $bankManager['bank_branch'] = $data['branch_name'];

        return $bankManager;
    }

}
