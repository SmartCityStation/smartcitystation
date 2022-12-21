<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class sendEmailNew extends Mailable
{
    use Queueable, SerializesModels;
    
    public $measuresAlerts;
    public $device;
    public $sector, $address;
    public $subject = "Notificacion Umbral SmartCityStation";
    

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($measuresAlerts, $device, $sector, $address)
    {
        
        $this->measuresAlerts = $measuresAlerts;
        $this->device = $device;
        $this->subject = $this->subject;
        $this->sector = $sector;
        $this->address = $address;
       
        // travels array measuresAlerts for send subject date and hour of the insert db
        // if (is_array($this->measuresAlerts)) {
        //     for ($row = 0; $row < count($this->measuresAlerts); $row++) { 
        //         $this->subject = $this->subject . " ". $this->measuresAlerts[$row][2] . " - ". $this->measuresAlerts[$row][3];
        //     }
        // }
        



    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('email.sendemail')
                    ->with($this->measuresAlerts, $this->device, $this->sector, $this->address);
    }
}
