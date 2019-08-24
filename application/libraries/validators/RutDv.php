<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include_once(APPPATH.'libraries/validators/Rule.php');

class RutDv extends Rule{

  /**
   * @Override
   *
   **/
  protected function evaluate() {
    $rut = $this->parse($this->value);
    if (strlen($rut) < 8) {
      $this->isValid = false;
      return;
    }

    $dv = substr($rut,-1);
    $rut = substr($rut,0,-1);
    
    if ($this->getDv($rut) == $dv) {
      $this->isValid = true;
      return;
    }

    $this->isValid = false;
  }

  public function getDv($r){
    $s=1;
    for($m=0;$r!=0;$r/=10)
        $s=($s+$r%10*(9-$m++%6))%11;
    return chr($s?$s+47:75);
  }

  public static function parse($value) {
    return strtoupper(preg_replace('/[^0-9kK]/', '', $value));
  }

  /**
   * @Override
   *
   **/
  public function getValue() {
    return $this->parse($this->value);
  }

}