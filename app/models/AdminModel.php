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
      $this->db->bind(":user_id", 1);
      $this->db->bind(":image", $data["image"]);
      return $this->db->execute();
    } catch (PDOException $ex) {
      echo $ex->getMessage();
    }
  }

  public function getAllPosts() {
    try {
      $this->db->query("SELECT p.id, p.title, p.body, p.image, p.category_id, p.user_id, u.username, c.name 
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
      $this->db->query("UPDATE posts SET title = :title, body = :body, image = :image, category_id = :category_id WHERE id = :id");
      $this->db->bind(":title", $data["title"]);
      $this->db->bind(":body", $data["body"]);
    
      $this->db->bind(":image", $data["image"]);
      $this->db->bind(":category_id", $data["category"]);
      $this->db->bind(":id", $id);
      return $this->db->execute();

    } catch (PDOException $ex) {
      echo $ex->getMessage();
    }
  }

  public function deletePost($id) {
    try {
      $this->db->query("DELETE FROM posts WHERE id = :id");
      $this->db->bind(":id", $id);
      return $this->db->execute();
      
    } catch (PDOException $ex) {
      echo $ex->getMessage();
    }
  }

  public function getAllComments() {
    try {
      $this->db->query("SELECT * FROM comments");
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
    try {
      $this->db->query("DELETE FROM categories WHERE id = :id");
      $this->db->bind(":id", $id);
      return $this->db->execute();
      
    } catch (PDOException $ex) {
      echo $ex->getMessage();
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


}

?>