<?php
 
  class Page extends Controller {
    public function __construct() {
      $this->page_model = $this->model("PageModel");
    }

    public function index() {
      if($_SERVER["REQUEST_METHOD"] == "GET") {
        $posts = $this->page_model->getPosts();
        $this->view('pages/main_page', $posts);
      }
    }

    public function post($id) {
      if($_SERVER["REQUEST_METHOD"] == "GET") {
        $post = $this->page_model->getPost($id);
        $this->view('pages/singlePost_page', $post);
      }
    }

   
  }