<?php

namespace App\DTO;

class MeasureObject
{
    public $hour;
    public $data;

    public function __construct($inputhora, $inputdato) 
    {
        $this->hour = $inputhora;
        $this->data = $inputdato;        
    }    
}