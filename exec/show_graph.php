<?php
namespace booosta\graph;

require_once __DIR__ . '/../../../../vendor/autoload.php';

use booosta\Framework as b;
b::croot();
b::load();

class Show extends \booosta\webapp\Webapp
{
  protected function action_default()
  {
    if(isset($this->VAR['obj'])):
      $obj = unserialize($this->VAR['obj']);

      if(is_object($obj)) $obj->output_image();
      #else \booosta\debug($obj);
      #else \booosta\debug("no object:\n" . $this->VAR['obj']);;
    endif;

    $this->no_output = true;
  }
}

$show = new Show();
$show();
