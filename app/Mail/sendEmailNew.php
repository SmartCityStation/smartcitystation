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
    public $subsectorArray;
    public $subject = "Notificacion Umbral SmartCityStation";
    

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($measuresAlerts, $subsectorArray)
    {
        
        $this->measuresAlerts = $measuresAlerts;
        $this->subsectorArray = $subsectorArray;
        $this->subject = $this->subject;
       
        if (is_array($this->measuresAlerts)) {
            for ($row = 0; $row < count($this->measuresAlerts); $row++) { 
                $this->device = $this->measuresAlerts[$row][0];
            }
        }

        if (is_array($this->subsectorArray)) {
            for ($row = 0; $row < count($this->subsectorArray); $row++) { 
                $this->sector = $this->subsectorArray[$row][0];
                $this->address = $this->subsectorArray[$row][1];
            }
        }

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
