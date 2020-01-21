<?php

namespace App\Events\InnerWebsite;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class NotificationMessageEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $data = array();

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct( $senderUserID, $senderName, $senderImage, $receiverUserID, $notificationType, $message )
    {
        $this->compose_data( $senderUserID, $senderName, $senderImage, $receiverUserID, $notificationType, $message );
    }


    private function compose_data( $senderUserID, $senderName, $senderImage, $receiverUserID, $notificationType, $message )
    {
        $this->data['sender_id'] = $senderUserID;

        $this->data['sender_name'] = $senderName;

        $this->data['receiver_id'] = $receiverUserID;

        $this->data['type'] = $notificationType;

        $this->data['message'] = $message;

        $this->data['image'] = $this->choose_image( $senderImage, $notificationType );
    }

    private function choose_image( $senderImage, $notificationType )
    {
        if( $senderImage == null ) {
            return "{'type' : 'icon','src' : 'fas fa-envelope'}";
        }
        else{
            switch ( $notificationType ) {
                case 0: {    
                    $image_temp = '/storage/uploads/users_profile_picture/';
                    return '{"type" : "picture","src" : "'.$image_temp.'"}';
                }
                case 1: {
                    $image_temp = '/storage/uploads/users_profile_picture/';
                    return '{"type" : "picture","src" : "'.$image_temp.'"}';
                }
                case 2: {
                    //bill payment
                    $image_temp = '/storage/uploads/users_profile_picture/';
                    return '{"type" : "picture","src" : "'.$image_temp.'"}';
                }
                case 3: {
                    $image_temp = '/storage/uploads/ticket_payments_logo/';
                    return '{"type" : "picture","src" : "'.$image_temp.'"}';
                }
                case 4: {
                    $image_temp = '/storage/uploads/banks_logo/';
                    return '{"type" : "picture","src" : "'.$image_temp.'"}';
                }
                case 5: {
                    $image_temp = '/storage/uploads/yoippsp_logo.png';
                    return '{"type" : "picture","src" : "'.$image_temp.'"}';
                }
                default:{
                    return '{"type":"icon","src":"text-12 text-yellow fas fa-envelope mr-3"}';
                }
            }
        }
    }

}
