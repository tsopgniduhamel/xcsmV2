<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;

class notificationMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public $data;

    public function __construct($data)
    {
        $this->data=$data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        
        if(Auth::user()->is_admin==0){
            $address=Auth::user()->email;
            $subject="Commentaire";

            $from=$address;
            $classe=Auth::user()->class;

            return $this->view('mail', compact("from", "classe"))
                        ->from($address)
                        ->subject($subject);    
        }else{
            
            $address=Auth::user()->email;

            $subject=$this->data['sujet'];
            $from=$address;
            $classe="";

            return $this->view('mail', compact("from", "classe"))
                        ->from($address)
                        ->subject($subject);    

        }

        
    }
}
