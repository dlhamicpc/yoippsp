<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;


class User extends \TCG\Voyager\Models\User
{
    use Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'role_id' ,'mobile_number',
        'email', 'password', 'avatar',
        'last_login_ip',
        'last_login_device_info',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token','banned_until','created_at','updated_at',
        'deleted_at', 'email_verified_at', 'online', 'password_changed_at'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'settings' => 'string',
    ];


    //Defining Relation ship
    public function personal_user()
    {
        return $this->hasOne(\App\Models\InnerWebsite\PersonalUser::class);
    }

    public function bill_payment_user()
    {
        return $this->hasOne(\App\Models\InnerWebsite\BillPaymentUser::class);
    }

    public function website_user()
    {
        return $this->hasOne(\App\Models\InnerWebsite\WebsiteUser::class);
    }

    public function bank_user()
    {
        return $this->hasOne(\App\Models\InnerWebsite\Bank::class);
    }

    public function bank_manager()
    {
        return $this->hasOne(\App\Models\InnerWebsite\BankManager::class);
    }

    public function api()
    {
        return $this->hasOne(\App\Models\InnerWebsite\Api::class);
    }

    public function user_card_links()
    {
        return $this->hasMany(\App\Models\InnerWebsite\UserCardLink::class);
    }

    public function user_bank_links()
    {
        return $this->hasMany(\App\Models\InnerWebsite\UserBankLink::class);
    }

    public function transactions()
    {
        return $this->hasMany(\App\Models\InnerWebsite\Transaction::class);
    }

    public function website_payment_transactions()
    {
        return $this->hasMany(\App\Models\InnerWebsite\WebsitePaymentTransaction::class);
    }

    public function website_payment_transaction_temporaries()
    {
        return $this->hasMany(\App\Models\InnerWebsite\WebsitePaymentTransactionTemporary::class);
    }

    public function bill_payment_user_and_customer()
    {
        return $this->hasOne(\App\Models\InnerWebsite\BillPaymentUserAndCustomer::class);
    }

    public function user_bill_payment_informations()
    {
        return $this->hasMany(\App\Models\InnerWebsite\UserBillPaymentInformation::class);
    }
}
