<?php
namespace booosta\graph;

require_once 'phpgraphlib.php';
require_once 'phpgraphlib_pie.php';

use \booosta\Framework as b;
b::init_module('graph');

abstract class Graph extends \booosta\base\Module
{ 
  use moduletrait_graph;

  protected $title;
  protected $data;
  protected $height, $width;

  public function __construct($data = null, $title = null, $height = 300, $width = 400)
  {
    parent::__construct();

    if($data === null) $data = [];
    $this->data = $data;
    $this->title = $title;
    $this->height = $height;
    $this->width = $width;
  }

  public function set_data($data) { $this->data = $data; }
  public function set_title($title) { $this->title = $title; }

  public function add_data($data)
  {
    if(is_array($data)) $this->data = array_merge($this->data, $data);
    else $this->data[] = $data;
  }

  public function set_config($config)
  {
    if(!is_array($config)) return false;

    $this->set_data($config['data']);
    $this->set_title($config['title']);
  }
 
  public function encode($obj) { return urlencode(serialize($obj)); }
  public function get_link() { return 'vendor/booosta/graph/exec/show_graph.php?obj=' . $this->encode(); }
  public function get_html() { return "<img src='" . $this->get_link() ."'>"; }

  abstract public function output_image();
}
