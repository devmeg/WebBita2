<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include_once(APPPATH.'libraries/validators/Rule.php');

class RutDv extends Rule{

  /**
   * @Override
   *
   **/
  protected function evaluate()
  {
    if ($this->validateRut($this->value)) {
      $this->isValid = true;
    } else {
      $this->isValid = false;
    }
  }

    /**
   * @Override
   *
   **/
  public function getValue()
  {
    return $this->parse($this->value);
  }

  public static function getDv($r)
  {
    $s=1;
    for($m=0;$r!=0;$r/=10)
        $s=($s+$r%10*(9-$m++%6))%11;
    return chr($s?$s+47:75);
  }

  public static function validateRut($value)
  {
    $rut = self::parse($value);
    if (strlen($rut) < 8) {
      return false;
    }

    $dv = substr($rut,-1);
    $rut = substr($rut,0,-1);
    
    if (self::getDv($rut) == $dv) {
      return true;
    }

    return false;
  }

  public static function parse($value)
  {
    return strtoupper(preg_replace('/[^0-9kK]/', '', $value));
  }

  public static function format($value)
  {
    $dv = substr($value,-1);
    $rut = substr($value,0,-1);

    $rut = substr_replace($rut,".",-6,0);
    $rut = substr_replace($rut,".",-3,0);

    return $rut."-".$dv;  
  }

}