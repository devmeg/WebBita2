<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include_once(APPPATH.'libraries/validators/Rule.php');

class Telefono extends Rule{

  /**
   * @Override
   *
   **/
  protected function evaluate() {
    $telefono = $this->value;
    if (strlen($telefono) == 9 && is_numeric($telefono)) {
      $this->isValid = true;
      return;
    }

    $this->isValid = false;
  }

  public static function format($value)
  {
    $codigo = substr($value,0,1);
    
    if ($codigo == "9") {
      $fono = substr_replace($value," ",1,0);
      

    } else { 
      $fono = substr_replace($value," ",2,0);

    }
    return "+56 ".$fono;
  }

}
