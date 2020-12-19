<?php

  class UserModel {
    
    public function __construct() {
      $this->db = new Database();
    }

    public function createUser($data) {

      $error = array();
      $error["username"] = "";
      $error["email"] = "";

      try {
        $this->db->query("SELECT * FROM users WHERE username = :username");
        $this->db->bind(":username", $data["username"]);
        $this->db->execute();
        $f_rowCount = $this->db->rowCount();

        if($f_rowCount > 0) {
          $error["username"] = "Username is already taken.";
        }
      } catch (PDOException $ex) {
        echo $ex->getMessage();
      }
     
      try {
        $this->db->query("SELECT * FROM users WHERE email = :email");
        $this->db->bind(":email", $data["email"]);
        $this->db->execute();
        $s_rowCount = $this->db->rowCount();
  
        if($s_rowCount > 0) {
          $error["email"] = "Email is already used.";
        }
      } catch (PDOException $ex) {
        echo $ex->getMessage();
      }
   
      if(!empty($error["username"]) || !empty($error["email"])) {
        return $error;
      }

      try {
        $this->db->query("INSERT INTO users 
        (username, email, password) 
        VALUES 
        (:username, :email, :password)");
        $this->db->bind(":username", $data["username"]);
        $this->db->bind(":email", $data["email"]);
        $this->db->bind(":password", $data["password"]);
        return $this->db->execute();


      } catch (PDOException $ex) {
        echo $ex->getMessage();
      }
    }

    public function findUser($username_email) {
      $result = false;
      try {
        $this->db->query("SELECT * FROM users WHERE email = :email");
        $this->db->bind(":email", $username_email);
        $this->db->execute();
        $f_rowCount = $this->db->rowCount();
  
        if($f_rowCount > 0) {
          $result = true;

          $user_data = $this->db->getResult();
          $id = $user_data["id"];
        }
      } catch (PDOException $ex) {
        echo $ex->getMessage();
      }

      try {
        $this->db->query("SELECT * FROM users WHERE username = :username");
        $this->db->bind(":username", $username_email);
        $this->db->execute();
        $s_rowCount = $this->db->rowCount();
  
        if($s_rowCount > 0) {
          $result = true;

          $user_data = $this->db->getResult();
          $id = $user_data["id"];
        }
      } catch (PDOException $ex) {
        echo $ex->getMessage();
      }

      if($result) {
        return $id;
      } else {
        return false;
      }
    }

    public function varifyUser($id, $password) {
      try {
        $this->db->query("SELECT * FROM users WHERE id = :id");
        $this->db->bind(":id", $id);
        $this->db->execute();
        $rowCount = $this->db->rowCount();
  
        if($rowCount > 0) {
          
          $user_data = $this->db->getResult();
          $hashed_password = $user_data["password"];

          if(password_verify($password, $hashed_password)) {
            return $user_data;
          } else {
            return false;
          }

        } else {
          return false;
        }
      } catch (PDOException $ex) {
        echo $ex->getMessage();
      }
    }



  }

?>