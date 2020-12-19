<?php 

  class Admin extends Controller {

    public function __construct() {
      $this->adminModel = $this->model('AdminModel');
    }

    public function index($edit = null, $id = null) {
      if($_SERVER['REQUEST_METHOD'] == 'GET') {
        $display = "";
        $postData = array();
        $commentData = array();
        $categoryData = array();
        $userData = array();

        switch($edit) {
          case "posts":
            $display = "posts";
            $postData = $this->adminModel->getAllPosts();
          break;
          case "cposts":
            $display = "cposts";
            $categoryData = $this->adminModel->getAllCategories();
          break;
          case "categories":
            $display = "categories";
            $categoryData = $this->adminModel->getAllCategories();
          break;
          case "ccategories":
            $display = "ccategories";
          break;
          case "comments":
            $display = "comments";
            $commentData = $this->adminModel->getAllComments();
          break;
          case "users":
            $display = "users";
            $userData = $this->adminModel->getAllUsers();
          break;
          case "uposts":
            $display = "uposts";
            $postData = $this->adminModel->getPost($id);
            $categoryData = $this->adminModel->getAllCategories();
          break;
          default:
            
        }
        $data_container = array();
        $data_container["display"] = $display;
        $data_container["posts"] = $postData;
        $data_container["comments"] = $commentData;
        $data_container["categories"] = $categoryData;
        $data_container["users"] = $userData;
        $this->view("admin/main_admin", $data_container);
      }
    }

    public function posts($id = null) {

      if(!isset($_SESSION["user_id"]) || $_SESSION["user_role"] !== "admin") {
        echo "You are not authorized to post.";
        die();
      }

      if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['post'])) {
        $_POST  = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        $tem_title = trim($_POST["title"]);
        $tem_body = $_POST["body"];
        if(isset($_POST["category"])) {
          $tem_category = $_POST["category"];
          $category_id = intval($_POST["category"]);
        }
        $user_id = $_SESSION["user_id"];

        // Error Info
        $error = array();
        $error["title"] = "";
        $error["category"] = "";
        $error["body"] = "";
        $error["image"] = "";

        if(!isset($_POST["category"])) {
          $error["category"] = "Category must be set.";
        }
        
        // image info
        $tem_image = $_FILES["file"];
        $tem_filename = $tem_image["name"];
        $tem_filetype = $tem_image["type"];
        $tem_filetmp = $tem_image["tmp_name"];
        $tem_filesize = $tem_image["size"];
        $tem_fileerror = $tem_image["error"];

        // -> start iamge test
        $tem_fileExt = explode(".", $tem_filename);
        $tem_actFileExt = strtolower(end($tem_fileExt));

        $arrowed_ext = ["jpg", "jpeg", "png", "pdf"];

        if(!in_array($tem_actFileExt, $arrowed_ext)) {
          $error["image"] = "image format must be jpg, jpeg, png, or pdf.";
        }

        if($tem_fileerror !== 0) {
          $error["image"] = "Something wrong with the image you selected. Try another one.";
        }

        if($tem_filesize > 1000000) {
          $error["image"] = "image size is too big. Try another one.";
        }

        
        // <- end image test

      
        if(empty($tem_title)) {
          $error["title"] = "title cannot be empty.";
        }

        if(empty($tem_body)) {
          $error["body"] = "body cannot be empty.";
        }

        if(!$error["title"]  && !$error["body"] && !$error["category"]) {

          
          // save images ->
          if(empty($error["images"])) {
            $unique = uniqid("", true);
            $filename = $unique . "." . $tem_actFileExt;
    
            $fileDestination = "app/views/uploads/" . $filename;
    
            move_uploaded_file($tem_filetmp, $fileDestination);
      
            // <- saved image 

            $data = array();
            $data["title"] = trim($_POST["title"]);
           
            $data["body"] = $_POST["body"];
            $data["image"] = $filename;
            $data["category"] = $category_id;
            $data["user_id"] = $user_id;
            
            if($this->adminModel->createPost($data)) {
              redirect("admin/index/posts");
            } else {
              echo "failed";
            }
        }
        } else {
          $data_container = array();
          $data_container["display"] = "cposts";
          $data_container["error"] = $error;
          $data_container["categories"] = $this->adminModel->getAllCategories();
          $this->view("admin/main_admin", $data_container);
        }
      } elseif($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {

          $_POST  = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
          $tem_title = trim($_POST["title"]);
          $tem_body = $_POST["body"];
          $tem_category = $_POST["category"];
          $tem_status = $_POST["status"];

          $error = array();
          $error["title"] = "";
          $error["status"] = "";
          $error["category"] = "";
          $error["body"] = "";
          $error["image"] = "";

           // image info
           $tem_image = $_FILES["file"];
           $tem_filename = $tem_image["name"];
           $tem_filetype = $tem_image["type"];
           $tem_filetmp = $tem_image["tmp_name"];
           $tem_filesize = $tem_image["size"];
           $tem_fileerror = $tem_image["error"];

           if(!($tem_image["size"])) {
             $prev_image = $this->adminModel->getPostImage(intval($id));
           } else {
              // -> start iamge test

              $tem_fileExt = explode(".", $tem_filename);
              $tem_actFileExt = strtolower(end($tem_fileExt));

              $arrowed_ext = ["jpg", "jpeg", "png", "pdf"];

              if(!in_array($tem_actFileExt, $arrowed_ext)) {
                $error["image"] = "image format must be jpg, jpeg, png, or pdf.";
              }

              if($tem_fileerror !== 0) {
                $error["image"] = $tem_image;
              }

              if($tem_filesize > 1000000) {
                $error["image"] = "image size is too big. Try another one.";
              }

              // <- end image test
           }
   
          
   

        if(empty($tem_title)) {
          $error["title"] = "title cannot be empty.";
        }

        if(empty($tem_body)) {
          $error["body"] = "body cannot be empty.";
        }

        if(($tem_status !== 'draft') && ($tem_status !== 'public')) {
          $error["status"] = "status must be set.";
        }

        if(empty($tem_category)) {
          $error["category"] = "category must be set.";
        } else {
          $category_id = intval($_POST["category"]);
        }

        if(!$error["title"] && !$error["body"] && !$error["status"] && !$error["category"] && !$error["image"]) {

           // save images ->
           if(!isset($prev_image)) {
            $unique = uniqid("", true);
            $filename = $unique . "." . $tem_actFileExt;
    
            $fileDestination = "app/views/uploads/" . $filename;
    
            move_uploaded_file($tem_filetmp, $fileDestination);
           } 
            // <- saved image 
            $data = array();
            $data["title"] = trim($_POST["title"]);
            $data["body"] = $_POST["body"];
            $data["image"] = isset($prev_image) ? $prev_image : $filename;
            $data["status"] = $_POST["status"];
            $data["category"] = $category_id;
            if($this->adminModel->updatePost($data, $id)) {
              // redirect("admin/index/posts");
              redirect("admin/index/posts");
            } else {
              echo "failed";
            }
         
        } else {
          $data_container = array();
          $data_container["display"] = "uposts";
          $data_container["error"] = $error;
          $data_container["posts"] = $_POST;
          $data_container["categories"] = $this->adminModel->getAllCategories();
          $data_container["posts"]["id"] = $id;
          $this->view("admin/main_admin", $data_container);
        }
      }
    }
  

  public function categories() {
    if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['post'])) {
      $_POST  = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
      $tem_name = trim($_POST["name"]);
   
      // Error Info
      $error = array();
      $error["name"] = "";

      if(empty($tem_name)) {
        $error["name"] = "Category name cannot be empty.";
      }

      if(empty($error["name"])) {
          // <- saved image 
          $data = array();
          $data["name"] = trim($_POST["name"]);
          if($this->adminModel->createCategory($data)) {
            // redirect("admin/index/posts");
            redirect("admin/index/categories");
          } else {
            echo "failed";
          }

        } else {
          $data_container = array();
          $data_container["display"] = "ccategories";
          $data_container["error"] = $error;
          $this->view("admin/main_admin", $data_container);
        }
      
     
  
      }}

      
    public function delete($id, $table) {
      
      if(!isset($id) || !isset($table)) {
        redirect("admin/index");
        exit;
      }

      $result;

      switch($table) {
        case "post":
          $result = $this->adminModel->deletePost($id);
        break;
        case "comment":
          $result = $this->adminModel->deleteComment($id);
        break;
        case "category":
          $result = $this->adminModel->deleteCategory($id);
        break;
        case "user":
          $result = $this->adminModel->deleteUser($id);
        break;
        default:
      }

      if($result) {
        redirect("admin/index");  
      } else {
        redirect("admin/index");
      }
    }

    public function status($id, $table) {
      if(!isset($id) || !isset($table)) {
        redirect("admin/index");
        exit;
      }

      $result;

      switch($table) {
        case "category":
          $result = $this->adminModel->c_statusCategory($id);
        break;
        default:
      }

      if($result) {
        redirect("admin/index/categories");  
      } else {
        redirect("admin/index/categories");
      }
    }
  }

?>