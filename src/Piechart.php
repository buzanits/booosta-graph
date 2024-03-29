<?php
namespace booosta\graph;

class Piechart extends Graph
{
  protected $color, $colors = [];   // Legend color and data colors
  protected $datavalues;

  public function __construct($data = null, $title = null)
  {
    parent::__construct($data, $title);
    $this->color = 'black';
    $this->datavalues = false;
  }

  public function set_color($color) { $this->color = $color; }
  public function set_colors($colors) { $this->colors = $colors; }
  public function set_datavalues($datavalues) { $this->datavalues = $datavalues; }

  public function set_config($config)
  {
    if(parent::set_config($config) === false) return false;

    $this->set_color($config['color']);
  }

  public function encode($dummy = null)
  {
    // create a copy of this object without all the booosta variables
    $obj = new Piechart($this->data, $this->title);
    $obj->set_color($this->color);
    $obj->set_colors($this->colors);
    $obj->set_datavalues($this->datavalues);

    #\booosta\debug($obj);
    return parent::encode($obj);
  }

  public function output_image($file = null)
  {
    $graph = new PHPGraphLibPie($this->width, $this->height, $file);
    $graph->set_colors($this->colors);
    $graph->addData($this->data);
    $title = $this->title === null ? ' ' : $this->title;
    $graph->setTitle($title);

    $graph->setLabelTextColor($this->color);
    $graph->setDataValues($this->datavalues);

    $graph->createGraph();
  }
}

class PHPGraphLibPie extends \PHPGraphLibPie
{
  public function set_colors($colors)
  {
    $this->pie_avail_colors = array_replace($this->pie_avail_colors, $colors);
  }
}
