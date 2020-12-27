<?php

class Profile extends Controller {

  public function __construct() {
    $this->profileModel = $this->model("ProfileModel");
  }

  public function index($user_id) {
    if(!isset($_SESSION["user_id"]) || $_SESSION["user_role"] !== "subscriber") {
      redirect();
      exit();
    }

    $user_data = $this->profileModel->findUser($user_id);
    if($user_data) {
      $data = array();
      $data["user"] = $user_data;
      $this->view("profile/subscriber_profile" ,$data);
    }
  }

  public function update($user_id = null) {
    if($user_id == null) {
      redirect();
      exit();
    } elseif(!isset($_SESSION["user_id"]) || $_SESSION["user_role"] !== "subscriber") {
      redirect();
      exit();
    } elseif($_SERVER["REQUEST_METHOD"] !== "POST") {
      redirect();
      exit();
    } elseif(!isset($_POST["submit"])) {
      redirect();
      exit();
    } 

    
    $_POST  = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
    $tem_username = trim($_POST["username"]);
    $tem_email = $_POST["email"];
  

    $error = array();
    $error["username"] = "";
    $error["email"] = "";
    $error["image"] = "";


     // image info
     $tem_image = $_FILES["file"];
     $tem_filename = $tem_image["name"];
     $tem_filetype = $tem_image["type"];
     $tem_filetmp = $tem_image["tmp_name"];
     $tem_filesize = $tem_image["size"];
     $tem_fileerror = $tem_image["error"];

     $user_data = $this->profileModel->findUser($user_id);

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

    
    if(!$error["username"] && !$error["email"] && !$error["image"]) {

      

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
       
        $update_result = $this->profileModel->updateUser($data, $user_id);
        
        if(!$update_result["error"]["username"] && !$update_result["error"]["email"] && $update_result) {
          // redirect("admin/index/posts");

          
         
          redirect("profile/index/$user_id");
        } elseif($update_result["error"]["username"] || $update_result["error"]["email"]) {
        
          $data_container = array();
          $data_container["user"] = $_POST;
          $data_container["user"]["id"] = $user_id;
          $data_container["user"]["avator"] = $user_data["avator"];
          $data_container["error"]["username"] = $update_result["error"]["username"] ? $update_result["error"]["username"] : "";
          $data_container["error"]["email"] = $update_result["error"]["email"] ? $update_result["error"]["email"] : "";
          $this->view("profile/subscriber_profile", $data_container);
        }
       } else {

      
        $data_container = array();
        $data_container["user"] = $_POST;
        $data_container["user"]["id"] = $user_id;
        $data_container["user"]["avator"] = $user_data["avator"];
        $data_container["error"] = $error;
        $this->view("profile/subscriber_profile", $data_container);
    
       }

    } else {
      redirect();
      exit();
    }
  } 
}

?>