<?php
namespace booosta\captcha;

use \booosta\Framework as b;
b::init_module('captcha');

class Captcha extends \booosta\ui\UI
{
  use moduletrait_captcha;

  public function __construct($name = null)
  {
    parent::__construct();
    $this->id = "captcha_$name";
  }

  public function after_instanciation()
  {
    parent::after_instanciation();

    if(is_object($this->topobj) && is_a($this->topobj, "\\booosta\\webapp\\Webapp")):
      $this->topobj->moduleinfo['captcha'] = true;
      if($this->topobj->moduleinfo['jquery']['use'] == '') $this->topobj->moduleinfo['jquery']['use'] = true;
    endif;
  }

  public function get_htmlonly() { 
    return "<input type='text' name='$this->id' id='$this->id'>";
  }

  public function get_js()
  {
    $regentext = $this->t('Click to change');
    $code = "$('#$this->id').realperson({regenerate: '$regentext'});";

    if(is_object($this->topobj) && is_a($this->topobj, "\\booosta\\webapp\\webapp")):
      $this->topobj->add_jquery_ready($code);
      return '';
    else:
      return "\$(document).ready(function(){ $code });";
    endif;
  }

  static public function rpHash($value) { 
    $hash = 5381; 
    $value = strtoupper($value); 
    for($i = 0; $i < strlen($value); $i++) { 
        $hash = (self::leftShift32($hash, 5) + $hash) + ord(substr($value, $i));
    } 
    return $hash; 
  }

  static protected function leftShift32($number, $steps) { 
    $binary = decbin($number); 
    $binary = str_pad($binary, 32, "0", STR_PAD_LEFT); 
    $binary = $binary.str_repeat("0", $steps); 
    $binary = substr($binary, strlen($binary) - 32); 
    return ($binary[0] == "0" ? bindec($binary) : -(pow(2, 31) - bindec(substr($binary, 1)))); 
  }
}
