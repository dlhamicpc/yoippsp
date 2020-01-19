<?php
namespace App\Http\Controllers\API\InnerWebsite\Transaction;

use App\User;
use App\Models\InnerWebsite\Transaction;
use App\Models\InnerWebsite\Bank;
use App\Models\InnerWebsite\PersonalUser;
use App\Models\InnerWebsite\UserBankLink;
use App\Models\InnerWebsite\UserCardLink;
use App\Models\InnerWebsite\Deposit;
use App\Models\InnerWebsite\YoippspBankAccountDetail;
use App\Events\InnerWebsite\NotificationMessageEvent;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public $senderModel;
    public $transactionSuccess = false;


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id = auth()->user()->id;
        $transactions = Transaction::where( 'sender_id' , $user_id )
                                    ->orWhere( 'receiver_id', $user_id )
                                    ->latest()
                                    ->paginate(10);

        return $transactions;
    }


    protected function find_user_balance( )
    {
        $role_id = auth()->user()->role_id;
        $this->senderRoleID = $role_id;

        switch ( $role_id ) {

            case 3: {
                $this->senderModel = auth()->user()->business_user;
                return auth()->user()->business_user->balance;
            }
            case 4: {
                $this->senderModel = auth()->user()->website_user;
                return auth()->user()->website_user->balance;
            }
            case 5:{
                $this->senderModel = auth()->user()->personal_user;
                return auth()->user()->personal_user->balance;
            }
            case 6:{
                $this->senderModel = auth()->user()->bill_payment_user;
                return auth()->user()->bill_payment_user->balance;
            }
            case 6:{
                $this->senderModel = auth()->user()->service_provider_user;
                return auth()->user()->service_provider_user->balance;
            }

            default:
                abort(403);
                break;
        }
    }

    protected function event_notification_message($senderUserID, $senderName, $senderImage, $receiverUserID, $notificationType, $message )
    {
         event( new NotificationMessageEvent(
            $senderUserID, $senderName, $senderImage, $receiverUserID, $notificationType, $message
          ));
    }

    protected function find_model( $role_id )
    {

        switch ($role_id) {
           /*  case 1:{
                return new \App\Models\InnerWebsite\YoippspAdminUser();
            }
            case 2:{
                return new \App\Models\InnerWebsite\BankUser();
            } */
            case 3:{
                return new \App\Models\InnerWebsite\BusinessUser();
            }
            case 4:{
                return new \App\Models\InnerWebsite\WebsiteUser();
            }
            case 5:{
                return new \App\Models\InnerWebsite\PersonalUser();
            }
            case 6:{
                return new \App\Models\InnerWebsite\BillPaymentUser();
            }
            case 7:{
                return new \App\Models\InnerWebsite\ServiceProviderUser();
            }
            default:
                abort(422, 'Invalid Request Information');
        }

    }


}
