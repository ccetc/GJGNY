<?php

namespace GJGNY\DataToolBundle\Resources\classes;

class Config {
  public $xlsDirectory;
  public $supportEmail;
  public $admins = array(); 
  
  public function __construct($xlsDirectory, $supportEmail, $admins) {
    $this->xlsDirectory = $xlsDirectory;
    $this->supportEmail = $supportEmail;
    
    
    foreach($admins as $county => $email)
    {
      $this->admins[$county] = $email;
    }
  }
}