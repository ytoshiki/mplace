<?php

  class Controller {

    public function __construct() {

    }
    
    public function model() {

    }

    public function view($path, $data = null) {
      if(file_exists('app/views/' . $path . '.php')) {
        require_once 'app/views/' . $path . '.php';
      }
    }
  }

?>