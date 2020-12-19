<?php

class User extends Controller {

  public function __construct() {
    $this->userModel = $this->model("UserModel");
  }

  public function signup() {

    if($_SERVER["REQUEST_METHOD"] == "GET") {

      $this->view("users/signup_page");

    } elseif($_SERVER["REQUEST_METHOD"] == "POST") {

      $_POST  = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

      $tem_username = $_POST["username"];
      $tem_email = $_POST["email"];
      $tem_password = $_POST["password"];
      $tem_sec_password = $_POST["sec_password"];

      // Error Info
      $error = array();
      $error["username"] = "";
      $error["email"] = "";
      $error["password"] = "";
      $error["sec_password"] = "";

      if(strlen($tem_username) < 4) {
        $error["username"] = "Username must include at least 4 characters";
      }

      if(empty($tem_email)) {
        $error["email"] = "Email must be provided";
      }

      if(strlen($tem_password) < 7) {
        $error["password"] = "Password must include at least 7 characters";
      }

      if($tem_password !== $tem_sec_password) {
        $error["sec_password"] = "Password must match";
      }

      if(empty($error["username"]) && empty($error["email"]) && empty($error["password"]) && empty($error["sec_password"])) {
          
        $data = array();
        $data["username"] = $_POST["username"];
        $data["email"] = $_POST["email"];
        $data["password"] = password_hash($_POST["password"], PASSWORD_DEFAULT);

        $result = $this->userModel->createUser($data);

        if(isset($result["username"]) || isset($result["email"])) {

          $data_container = array();
          $data_container["error"] = $error;
          $data_container["input"] = $_POST;

          if(!empty($result["username"])) {
            $data_container["error"]["username"] = $result["username"];  
          }

          if(!empty($result["email"])) {
            $data_container["error"]["email"] = $result["email"];  
          }

          $this->view("users/signup_page", $data_container);

        } elseif ($result == true) {

            redirect("user/login");
        } else {
          $data_container = array();
          $data_container["error"] = $error;
          $data_container["input"] = $_POST;
          $data_container["error"]["x"] = "There is something wrong with creating a new account";
          $this->view("users/signup_page", $data_container);
        }

      } else {
        $data_container = array();
        $data_container["error"] = $error;
        $data_container["input"] = $_POST;
        $this->view("users/signup_page", $data_container);
      }
    }

  }

  public function login() {
    if($_SERVER["REQUEST_METHOD"] == "GET") {
      $this->view("users/login_page");
    } elseif($_SERVER["REQUEST_METHOD"] == "POST") {
      $_POST  = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

      $tem_username_email = $_POST["username_email"];
      $tem_password = $_POST["password"];
  

      // Error Info
      $error = array();
      $error["first_row"] = "";
      $error["second_row"] = "";

      if(empty($tem_username_email)) {
        $error["first_row"] = "This field cannot be empty";
      }

      if(strlen($tem_password) < 7) {
        $error["second_row"] = "Password must include at least 7 characters";
      }


      if(empty($error["first_row"]) && empty($error["second_row"])) {
          
        $data = array();
        $data["username_email"] = $_POST["username_email"];
        $data["password"] = $_POST["password"];

        // if successful, user id gets returned
        $userFound = $this->userModel->findUser($data["username_email"]);

        if($userFound) {

          // if successful, user data gets returned
          $varify_result = $this->userModel->varifyUser($userFound, $data["password"]);

          if($varify_result) {

            $user_id = $varify_result["id"];
            $user_name = $varify_result["username"];
            $user_role = $varify_result["role"];

            $_SESSION["user_id"] = $user_id;
            $_SESSION["user_name"] = $user_name;
            $_SESSION["user_role"] = $user_role;

            redirect();

          } else {
            $data_container = array();
            $data_container["error"] = $error;
            $data_container["error"]["result"] = "Username/Email or Password is incorrect.";
            $this->view("users/login_page", $data_container);
          }

        } else {
          $data_container = array();
          $data_container["error"] = $error;
          $data_container["error"]["result"] = "User does not exist";
          $this->view("users/login_page", $data_container);
        }

        
      } else {
        $data_container = array();
        $data_container["error"] = $error;
        $this->view("users/login_page", $data_container);
      }
    }
  }

  public function logout() {
    unset($_SESSION["user_name"]);
    unset($_SESSION["user_id"]);
    unset($_SESSION["user_role"]);
    session_destroy();
    redirect();
  }

}

?>