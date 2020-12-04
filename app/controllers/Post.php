<?php
 
  class Post extends Controller {
    public function __construct() {
 
    }

    public function index() {
      if($_SERVER["REQUEST_METHOD"] == "GET") {
        $this->view('main_page', 'some data here');
      }
    }
  }