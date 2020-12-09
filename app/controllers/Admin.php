<?php 

  class Admin extends Controller {

    public function __construct() {
      $this->adminModel = $this->model('AdminModel');
    }

    public function index($edit = null) {
      if($_SERVER['REQUEST_METHOD'] == 'GET') {
        $display;
        switch($edit) {
          case "posts":
            $display = "posts";
          break;
          case "cposts":
            $display = "cposts";
          break;
          case "categories":
            $display = "categories";
          break;
          case "comments":
            $display = "comments";
          break;
          case "users":
            $display = "users";
          break;
          default:
            $display = "";
        }
        $data_container = array();
        $data_container["display"] = $display;
        $this->view("admin/main_admin", $data_container);
       
      }
    }

    public function posts($action = null) {
      if($_SERVER["REQUEST_METHOD"] == "POST") {
        $_POST  = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        $tem_title = trim($_POST["title"]);
        $tem_author = trim($_POST["author"]);
        $tem_body = $_POST["body"];

        $error = array();
        $error["title"] = "";
        $error["author"] = "";
        $error["body"] = "";

        if(empty($tem_title)) {
          $error["title"] = "title cannot be empty.";
        }

        if(empty($tem_author)) {
          $error["author"] = "author cannot be empty.";
        }

        if(empty($tem_body)) {
          $error["body"] = "body cannot be empty.";
        }

        if(!$error) {
          $data = array();
          $data["title"] = trim($_POST["title"]);
          $data["author"] = trim($_POST["author"]);
          $data["body"] = $_POST["body"];
        } else {
          $data_container = array();
          $data_container["display"] = "cposts";
        $data_container["error"] = $error;
        $this->view("admin/main_admin", $data_container);
        }
     

      }
    }




  }

?>