<?php
 
  class Page extends Controller {
    public function __construct() {
      $this->page_model = $this->model("PageModel");
    }

    public function index() {
      if($_SERVER["REQUEST_METHOD"] == "GET") {
        $data = array();
        
        $data["posts"] = $this->page_model->getPosts();
        $data["categories"] = $this->page_model->getCategories();
        $this->view('pages/main_page', $data);
      }
    }

    public function post($id) {
      if($_SERVER["REQUEST_METHOD"] == "GET") {
        $post = $this->page_model->getPost($id);
        $comments = $this->page_model->getComments($id);
        $data = array();
        $data["post"] = $post;
        $data["comments"] = $comments;
        $this->view('pages/singlePost_page', $data);
      }
    }

    public function comment($id) {

      
      if($_SERVER["REQUEST_METHOD"] == "POST") {

        if(!isset($_SESSION["user_id"])) {
          redirect();
          die();
        }

        $_POST  = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        $tem_comment = trim($_POST["comment"]);
        $tem_c_id = trim($_POST["category_id"]);
     
        // Error Info
        $error = array();
        $error["comment"] = "";
  
        if(empty($tem_comment)) {
          $error["comment"] = "Comment cannot be empty.";
        }
  
        if(empty($error["comment"])) {

            // <- saved image 
            $data = array();
            $data["comment"] = trim($_POST["comment"]);
            $data["post_id"] = intval($id);
            $data["user_id"] = intval($_SESSION["user_id"]);
            $data["category_id"] = intval($tem_c_id);

            // $this->view('pages/singlePost_page', $post);

            if($this->page_model->createComment($data)) {
              redirect("page/post/" . $id);
            } else {
              echo "failed";
            }
  
          } else {
            redirect("page/post/" . $id);
          }
  
      }
    }

   
  }