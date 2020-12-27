<?php 

class AdminModel {

  public function __construct() {
    $this->db = new Database();
  }

  public function createPost($data) {
    try {
      $this->db->query("INSERT INTO posts (title, category_id, user_id, body, image) VALUES (:title, :category_id, :user_id, :body, :image)");
      $this->db->bind(":title", $data["title"]);
      $this->db->bind(":body", $data["body"]);
      $this->db->bind(":category_id", $data["category"]);
      $this->db->bind(":user_id", $data["user_id"]);
      $this->db->bind(":image", $data["image"]);
      return $this->db->execute();
    } catch (PDOException $ex) {
      echo $ex->getMessage();
    }
  }

  public function getAllPosts() {
    try {
      $this->db->query("SELECT p.id, p.title, p.body, p.image, p.category_id, p.user_id, p.status, u.username, c.name 
      FROM posts AS p 
      LEFT JOIN users AS u ON p.user_id = u.id
      LEFT JOIN categories AS c ON p.category_id = c.id
      ");
      $this->db->execute();
      $rowCount = $this->db->rowCount();
      if($rowCount !== 0) {
        return $this->db->getResults();
      }
    } catch (PDOException $ex) {
      echo $ex->getMessage();
    }
  }

  public function getPost($id) {
    try {
      $this->db->query("SELECT * FROM posts WHERE id = :id");
      $this->db->bind(':id', $id);
      $this->db->execute();
      $rowCount = $this->db->rowCount();
      if($rowCount !== 0) {
        return $this->db->getResult();
      }
    } catch (PDOException $ex) {
      echo $ex->getMessage();
    }
  }

  public function updatePost($data, $id) {
    try {
      $this->db->query("UPDATE posts SET title = :title, body = :body, image = :image, category_id = :category_id, status = :status WHERE id = :id");
      $this->db->bind(":title", $data["title"]);
      $this->db->bind(":body", $data["body"]);
      $this->db->bind(":status", $data["status"]);
      $this->db->bind(":image", $data["image"]);
      $this->db->bind(":category_id", $data["category"]);
      $this->db->bind(":id", $id);
      return $this->db->execute();

    } catch (PDOException $ex) {
      echo $ex->getMessage();
    }
  }

  public function deletePost($id) {
    if($_SESSION["user_role"] !== "admin") {
      redirect();
      exit();
    }

      try {
        $this->db->query("DELETE FROM posts WHERE id = :id");
        $this->db->bind(":id", $id);
        $result_d = $this->db->execute();
        
      } catch (PDOException $ex) {
        echo $ex->getMessage();
      }
  
      if($result_d) {

        try {
          $this->db->query("DELETE FROM comments WHERE post_id = :id");
          $this->db->bind(":id", $id);
          $this->db->execute();
        } catch (PDOException $ex) {
          echo $ex->getMessage();
        }

        try {
          $this->db->query("DELETE FROM bookmarks WHERE post_id = :id");
          $this->db->bind(":id", $id);
          $this->db->execute();
        } catch (PDOException $ex) {
          echo $ex->getMessage();
        }

        return true;
      }



  }

  public function getAllComments() {
    try {
      $this->db->query("SELECT c.id, c.user_id, c.comment, c.post_id, u.username, p.title
       FROM comments AS c
       LEFT JOIN users AS u ON c.user_id = u.id
       LEFT JOIN posts AS p ON c.post_id = p.id");

      $this->db->execute();
      $rowCount = $this->db->rowCount();
      if($rowCount !== 0) {
        return $this->db->getResults();
      }
    } catch (PDOException $ex) {
      echo $ex->getMessage();
    }
  }

  public function getAllCategories() {
    try {
      $this->db->query("SELECT * FROM categories");
      $this->db->execute();
      $rowCount = $this->db->rowCount();
      if($rowCount !== 0) {
        return $this->db->getResults();
      }
    } catch (PDOException $ex) {
      echo $ex->getMessage();
    }
  }

  public function deleteCategory($id) {
    if($_SESSION["user_role"] !== "admin") {
      redirect();
      exit();
    }
    try {
      $this->db->query("DELETE FROM categories WHERE id = :id");
      $this->db->bind(":id", $id);
      $categorydelete = $this->db->execute();
      
    } catch (PDOException $ex) {
      echo $ex->getMessage();
    }

    if($categorydelete) {
      try {
        $this->db->query("DELETE FROM posts WHERE category_id = :id");
        $this->db->bind(":id", $id);
        $this->db->execute();
        
      } catch (PDOException $ex) {
        echo $ex->getMessage();
      }
    }

    if($categorydelete) {
      try {
        $this->db->query("DELETE FROM comments WHERE category_id = :id");
        $this->db->bind(":id", $id);
        $categorydelete = $this->db->execute();
        
      } catch (PDOException $ex) {
        echo $ex->getMessage();
      }
    }
  }

  public function createCategory($data) {
    try {
      $this->db->query("INSERT INTO categories (name) VALUES (:name)");
      $this->db->bind(":name", $data["name"]);
      
      return $this->db->execute();
    } catch (PDOException $ex) {
      echo $ex->getMessage();
    }
  }

  public function getAllUsers() {
    try {
      $this->db->query("SELECT * FROM users");
      $this->db->execute();
      $rowCount = $this->db->rowCount();
      if($rowCount !== 0) {
        return $this->db->getResults();
      }
    } catch (PDOException $ex) {
      echo $ex->getMessage();
    }
  }

  public function getUser($user_id) {
    try {
      $this->db->query("SELECT * FROM users WHERE id = :user_id");
      $this->db->bind(':user_id', $user_id);
      $this->db->execute();
      $rowCount = $this->db->rowCount();
      if($rowCount !== 0) {
        return $this->db->getResult();
      } else {
        return false;
      }
    } catch (PDOException $ex) {
      echo $ex->getMessage();
    }
  }

  public function deleteUser($id) {

    if($_SESSION["user_role"] !== "admin") {
      redirect();
      exit();
    }

    try {
      $this->db->query("DELETE FROM users WHERE id = :id");
      $this->db->bind(":id", $id);
      $userDelete =  $this->db->execute();
      
    } catch (PDOException $ex) {
      echo $ex->getMessage();
    }

    if($userDelete) {
      try {
        $this->db->query("DELETE FROM posts WHERE user_id = :id");
        $this->db->bind(":id", $id);
        $this->db->execute();
        
      } catch (PDOException $ex) {
        echo $ex->getMessage();
      }
    }

    if($userDelete) {
      try {
        $this->db->query("DELETE FROM comments WHERE user_id = :id");
        $this->db->bind(":id", $id);
        $this->db->execute();
        
      } catch (PDOException $ex) {
        echo $ex->getMessage();
      }
    }

    if($_SESSION["user_id"] == $id) {
      unset($_SESSION["user_name"]);
      unset($_SESSION["user_id"]);
      unset($_SESSION["user_role"]);
      session_destroy();
      redirect();
      exit();
    }


  }

  public function updateUser($data, $id) {

    try {
      $this->db->query("SELECT * FROM users WHERE username = :username");
  
      $this->db->bind(':username', $data["username"]);
      $this->db->execute();
      $rowCount = $this->db->rowCount();

      if($rowCount > 0) {
        $user = $this->db->getResult();
        if($user["id"] == $id) {
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
          if($user["id"] == $id) {
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
        $this->db->query("UPDATE users 
        SET username = :username, email = :email, avator = :avator, role = :role
        WHERE id = :id");
        $this->db->bind(":username", $data["username"]);
        $this->db->bind(":email", $data["email"]);
        $this->db->bind(":role", $data["role"]);
        $this->db->bind(":avator", $data["avator"]);
        $this->db->bind(":id", $id);
        return $this->db->execute();
      } catch (PDOException $ex) {
        echo $ex->getMessage();
      }

    }
   
  }

  public function deleteComment($id) {

    if($_SESSION["user_role"] !== "admin") {
      redirect();
      exit();
    }

    try {
      $this->db->query("DELETE FROM comments WHERE id = :id");
      $this->db->bind(":id", $id);
      return $this->db->execute();
      
    } catch (PDOException $ex) {
      echo $ex->getMessage();
    }
  }

  public function c_statusCategory($id) {

    if($_SESSION["user_role"] !== "admin") {
      redirect();
      exit();
    }

    try {
      $this->db->query("SELECT * FROM categories WHERE id = :id");
      $this->db->bind(':id', $id);
      $this->db->execute();
      $rowCount = $this->db->rowCount();
      if($rowCount !== 0) {
        $category_detail = $this->db->getResult();
        $status = $category_detail["status"];
      }
    } catch (\Throwable $th) {
      //throw $th;
    }

    if($status == "draft") {
      try {
        $this->db->query("UPDATE categories SET status = 'public' WHERE id = :id");
        $this->db->bind(':id', $id);
        $this->db->execute();
        $rowCount = $this->db->rowCount();
        if($rowCount !== 0) {
          return true;
        } else {
          return false;
        }
      } catch (\Throwable $th) {
        //throw $th;
      }
    } elseif($status == "public") {
      try {
        $this->db->query("UPDATE categories SET status = 'draft' WHERE id = :id");
        $this->db->bind(':id', $id);
        $this->db->execute();
        $rowCount = $this->db->rowCount();
        if($rowCount !== 0) {
          return true;
        } else {
          return false;
        }
      } catch (\Throwable $th) {
        //throw $th;
      }
    }

    
  }

  public function getPostImage($id) {
    try {
      $this->db->query('SELECT image FROM posts WHERE id = :id');
      $this->db->bind(':id', $id);
      $this->db->execute();
      $rowCount = $this->db->rowCount();
      if($rowCount > 0) {
        $post_detail = $this->db->getResult();
        $image = $post_detail["image"];
        return $image;
      } else {
        return false;
      }
    } catch (PDOException $ex) {
      echo $ex->getMessage();
    }
  
  }


}

?>