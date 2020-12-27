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
          case "uusers":
            $display = "uusers";
            $userData = $this->adminModel->getUser($id);
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
    
            $fileDestination = "app/views/uploads/posts/" . $filename;
    
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

            $fileDestination = "app/views/uploads/posts/" . $filename;
    
            move_uploaded_file($tem_filetmp, $fileDestination);

            $old_image = $this->adminModel->getPostImage(intval($id));

            deleteImage("app/views/uploads/posts/", $old_image);

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
          $post = $this->adminModel->getPost($id);
          $image = $post["image"];
          $result = $this->adminModel->deletePost($id);
          if($result) {
            deleteImage("app/views/uploads/posts/", $image);
          }
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

      redirect("admin/index");  
     
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

    public function update($id = null) {
      if($_SERVER["REQUEST_METHOD"] == 'POST' || $_SESSION['user_role'] == "admin") {
      

        if(!isset($_POST["submit"])) {
          redirect();
          exit();
      
        } else {
       
          $_POST  = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
          $tem_username = trim($_POST["username"]);
          $tem_email = $_POST["email"];
          $tem_role = $_POST["role"];
        
      
          $error = array();
          $error["username"] = "";
          $error["email"] = "";
          $error["image"] = "";
          $error["role"] = "";
      
      
           // image info
           $tem_image = $_FILES["file"];
           $tem_filename = $tem_image["name"];
           $tem_filetype = $tem_image["type"];
           $tem_filetmp = $tem_image["tmp_name"];
           $tem_filesize = $tem_image["size"];
           $tem_fileerror = $tem_image["error"];
      
           $user_data = $this->adminModel->getUser($id);
      
           if($user_data) {

           if($tem_image["size"] == 0) {
            $prev_image = $user_data["avator"];
      
      
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
      
          if(empty($tem_username)) {
            $error["username"] = "username cannot be empty.";
          }
      
          if(empty($tem_email)) {
            $error["email"] = "email cannot be empty.";
          }

          
          if(empty($tem_role)) {
            $error["role"] = "role cannot be empty.";
          }

          if(($tem_role !== "admin") && ($tem_role !== "subscriber")) {
            $error["role"] = "role must be either admin or subscirber.";
          }
      
          
          if(!$error["username"] && !$error["email"] && !$error["image"] && !$error["role"]) {
      
            
      
            if(!isset($prev_image)) { 
              $unique = uniqid("", true);
              $filename = $unique . "." . $tem_actFileExt;
      
              $fileDestination = "app/views/uploads/avators/" . $filename;
      
              move_uploaded_file($tem_filetmp, $fileDestination);
      
              $old_image = $user_data["avator"];
      
                if($old_image !== "avator.png") {
        
                  deleteImage("app/views/uploads/avators/", $old_image);
                }
      
              
            }
              // <- saved image 
      
              $data = array();
              $data["username"] = trim($_POST["username"]);
              $data["email"] = $_POST["email"];
              $data["avator"] = isset($prev_image) ? $prev_image : $filename;
              $data["role"] = $_POST["role"];
             
              $update_result = $this->adminModel->updateUser($data, $id);
              
              if(!$update_result["error"]["username"] && !$update_result["error"]["email"] && $update_result) {
                
                redirect("admin/index/users");
              } elseif($update_result["error"]["username"] || $update_result["error"]["email"]) {
              
                $data_container = array();
                $data_container["users"] = $_POST;
                $data_container["users"]["id"] = $id;
                $data_container["users"]["avator"] = $user_data["avator"];
                $data_container["error"]["username"] = $update_result["error"]["username"] ? $update_result["error"]["username"] : "";
                $data_container["error"]["email"] = $update_result["error"]["email"] ? $update_result["error"]["email"] : "";
                $data_container["display"] = "uusers";
                $this->view("admin/main_admin", $data_container);
              }
             } else {
      
            
              $data_container = array();
              $data_container["users"] = $_POST;
              $data_container["users"]["id"] = $id;
              $data_container["users"]["avator"] = $user_data["avator"];
              $data_container["error"] = $error;
              $data_container["display"] = "uusers";
              $this->view("admin/main_admin", $data_container);
          
             }
      
          } else {
            redirect();
            exit();
            
          }
          
        }
      
      }
    }
  }

?>