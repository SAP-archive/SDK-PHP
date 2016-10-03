<?php

namespace entity;

Class Entity {

  public function __construct($name, $data) {
    $this->name = $name;
    foreach ($data as $key => $value) {
      $this->$key = $value;
    }
  }
}

?>
