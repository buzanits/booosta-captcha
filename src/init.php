<?php
namespace booosta\captcha;

\booosta\Framework::add_module_trait('webapp', 'captcha\webapp');

trait webapp
{
  protected function preparse_captcha()
  {
    $libpath = 'vendor/booosta/captcha/src';
    if($this->moduleinfo['captcha'])
      $this->add_includes("<script type='text/javascript' src='{$this->base_dir}$libpath/jquery.plugin.js'></script>
            <script type='text/javascript' src='{$this->base_dir}$libpath/jquery.realperson.js'></script>
            <link rel='stylesheet' type='text/css' href='{$this->base_dir}$libpath/jquery.realperson.css' />\n");
  }

  public function check_captcha($name = null)
  {
    return Captcha::rpHash($this->VAR["captcha_$name"]) == $this->VAR["captcha_{$name}Hash"];
  }
} 
