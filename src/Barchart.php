<?php
namespace booosta\graph;

class Barchart extends Graph
{
  protected $color;
  protected $range;
  protected $datavalues;

  public function __construct($data = null, $title = null, $height = 300, $width = 400)
  {
    parent::__construct($data, $title, $height, $width);
    $this->color = ['red', 'maroon'];
    $this->range = null;
    $this->datavalues = false;
  }

  public function set_color($color) { $this->color = $color; }
  public function set_range($min, $max) { $this->range = ['min'=>$min, 'max'=>$max]; }
  public function set_datavalues($datavalues) { $this->datavalues = $datavalues; }

  public function set_config($config)
  {
    if(parent::set_config($config) === false) return false;

    $this->set_color($config['color']);
  }

  public function encode($dummy = null)
  {
    // create a copy of this object without all the booosta variables
    $obj = new Barchart($this->data, $this->title);
    $obj->set_color($this->color);
    if(is_array($this->range)) $obj->set_range($this->range['min'], $this->range['max']);
    $obj->set_datavalues($this->datavalues);

    #\booosta\debug($obj);
    return parent::encode($obj);
  }

  public function output_image($file = null)
  {
    $graph = new \PHPGraphLib($this->width, $this->height, $file);
    #\booosta\debug("new \PHPGraphLib($this->width, $this->height, $file)");
    $graph->addData($this->data);
    $title = $this->title ?? ' ';
    $graph->setTitle($title);
    
    if(is_array($this->color)) $graph->setGradient($this->color[0], $this->color[1]);
    else $graph->setBarColor($this->color);

    if(is_array($this->range)) $graph->setRange($this->range['min'], $this->range['max']);

    $graph->setDataValues($this->datavalues);

    $graph->createGraph();
  }
}
