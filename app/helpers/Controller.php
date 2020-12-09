<?php

  class Controller {

    public function __construct() {

    }
    
    public function model($model) {
      if(file_exists('app/models/' . $model . '.php')) {
        require_once 'app/models/'. $model . '.php';
        return new $model();
      }
    }

    public function view($path, $data = null) {
      if(file_exists('app/views/' . $path . '.php')) {
        require_once 'app/views/' . $path . '.php';
      }
    }
  }

?>