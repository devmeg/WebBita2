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

}
