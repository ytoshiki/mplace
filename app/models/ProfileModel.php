<?php 

class ProfileModel {
  public function __construct() {
    $this->db = new Database();
  }

  public function findUser($user_id) {
    try {
      $this->db->query("SELECT id, username, email, avator FROM users WHERE id = :id");
      $this->db->bind(':id', $user_id);
      $this->db->execute();
      $rowCount = $this->db->rowCount();
      if($rowCount) {
        return $this->db->getResult();
      } else {
        return false;
      }
    } catch (PDOException $ex) {
      echo $ex->getMessage();
    }
   
  }

  public function getUserImage($user_id) {
    $this->db->query("SELECT id, username, email, avator FROM users WHERE id = :id");
    $this->db->bind(':id', $user_id);
    $this->db->execute();
    $rowCount = $this->db->rowCount();
    if($rowCount) {
      return $this->db->getResult();
    } else {
      return false;
    }
  }

  public function updateUser($data, $user_id) {

     $return_data = array();
     $return_data["error"]["username"] = "";
     $return_data["error"]["email"] = "";

    try {
      $this->db->query("SELECT * FROM users WHERE username = :username");
  
      $this->db->bind(':username', $data["username"]);
      $this->db->execute();
      $rowCount = $this->db->rowCount();

      if($rowCount > 0) {
        $user = $this->db->getResult();
        if($user["id"] == $user_id) {
           $result = true;
        } else {
          $return_data["error"]["username"] = "Username is already taken.";
          return $return_data;
        }
      } else {
        $result = true;
      }

    } catch (PDOException $ex) {
      echo $ex->getMessage();
    }

    if($result) {
    try {
      $this->db->query("SELECT * FROM users WHERE email = :email");
  
      $this->db->bind(':email', $data["email"]);
      $this->db->execute();
      $rowCount = $this->db->rowCount();

      if($rowCount > 0) {
        $user = $this->db->getResult();
        if($user["id"] == $user_id) {
           $result = true;
        } else {
          $return_data["error"]["email"] = "Email is already taken.";
          return $return_data;
        }
      } else {
        $result = true;
      }

    } catch (PDOException $ex) {
      echo $ex->getMessage();
    }
  }
    
    if($result) {
    try {
      $this->db->query("UPDATE users SET username = :username, email = :email, avator = :avator WHERE id = :id");
    $this->db->bind(':id', $user_id);
    $this->db->bind(':username', $data["username"]);
    $this->db->bind(':email', $data["email"]);
    $this->db->bind(':avator', $data["avator"]);
    return $this->db->execute();
    } catch (PDOException $ex) {
      echo $ex->getMessage();
    }
    } else {

    }
    
  }

}

?>