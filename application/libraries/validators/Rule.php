<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rule {
  protected $value;
  protected $isValid = false;

  public function setValue($value) {
    $this->value = trim($value);
    $this->evaluate($this->value);
  }

  /**
   * Hacer Override del método
   * evalua la regla sobre `value` y guarda el resultado en `isValid`
   *
   * @return void
   **/
  protected function evaluate() {
    $this->isValid = true;
  }

  public function validate() {
    return $this->isValid;
  }

  public function getValue() {
    return $this->value;
  }
}