<?php

 class PageModel {

   public function __construct() {
      $this->db = new Database();
   }

   public function getPosts() {
      $this->db->query("SELECT 
      p.id, p.title, p.body, p.image, p.status, p.category_id, p.user_id, u.username, u.avator
      FROM posts AS p 
      LEFT JOIN users AS u 
      ON p.user_id = u.id
      WHERE p.status = :status
      LIMIT 3"
      );
      $this->db->bind(':status', 'public');
      $this->db->execute();
      return $this->db->getResults();
   }

   public function getAllPosts() {
      $this->db->query("SELECT 
      p.id, p.title, p.body, p.image, p.status, p.category_id, p.user_id, u.username, u.avator
      FROM posts AS p 
      LEFT JOIN users AS u 
      ON p.user_id = u.id
      WHERE p.status = :status"
      );
      $this->db->bind(':status', 'public');
      $this->db->execute();
      return $this->db->getResults();
   }

   public function getCategories() {
      $this->db->query("SELECT * FROM categories WHERE status = 'public' LIMIT 5");
      $this->db->execute();
      return $this->db->getResults();
   }

   public function getPost($id) {
      $this->db->query("SELECT p.id, p.title, p.body, p.image, p.category_id, p.user_id, u.username, u.avator
      FROM posts AS p 
      LEFT JOIN users AS u ON p.user_id = u.id
      WHERE p.id = :id");
      $this->db->bind(":id", $id);
      $this->db->execute();
      return $this->db->getResult();
   }

   public function getSimilarPosts($id, $category_id) { 
      $this->db->query("SELECT * FROM posts 
      WHERE category_id = :category_id 
      AND id != :id
      AND status = 'public'
      LIMIT 5");
      $this->db->bind(":category_id", $category_id);
      $this->db->bind(":id", $id);
      $this->db->execute();
      $rowCount = $this->db->rowCount();
      if($rowCount > 0) {
         return $this->db->getResults();
      } else {
         return false;
      }
   }

   public function createComment($data) {
      $this->db->query("INSERT INTO comments (user_id, comment, post_id, category_id) VALUES (:user_id, :comment, :post_id, :category_id)");
      $this->db->bind(":comment", $data["comment"]);
      $this->db->bind(":post_id", $data["post_id"]);
      $this->db->bind(":user_id", $data["user_id"]);
      $this->db->bind(":category_id", $data["category_id"]);
      return $this->db->execute();
   }

   public function getComments($post_id) {
      $this->db->query("SELECT c.id, c.user_id, c.comment, c.post_id, u.username, u.avator 
      FROM comments AS c 
      LEFT JOIN users AS u ON c.user_id = u.id
      WHERE c.post_id = :post_id");
      $this->db->bind(":post_id", $post_id);
      $this->db->execute();
      return $this->db->getResults();
   }

   public function filterByCategory($c_id) {
      $this->db->query("SELECT p.id, p.title, p.image, p.category_id, p.user_id, p.status, u.username
      FROM posts AS p
      LEFT JOIN users AS u ON p.user_id = u.id
      WHERE category_id = :c_id AND p.status = 'public'");
      $this->db->bind(':c_id', $c_id);
      $this->db->execute();
      $rowCount = $this->db->rowCount();
      if($rowCount > 0) {
         return $this->db->getResults();
      } else {
         return false;
      }
   }

   public function filterByKeyword($p_title) {
      $this->db->query("SELECT p.id, p.title, p.image, p.category_id, p.user_id, p.status, u.username, c.name
      FROM posts AS p
      LEFT JOIN users AS u ON p.user_id = u.id
      LEFT JOIN categories AS c ON p.category_id = c.id
      WHERE p.title LIKE CONCAT('%', :keyword, '%')
      ");

      $this->db->bind(":keyword", $p_title);
      $this->db->execute();
      $rowCount = $this->db->rowCount();
      if($rowCount > 0) {
         return $this->db->getResults();
      } else {
         return false;
      }
   }

   public function addBookmark($user_id, $post_id) {
      $this->db->query("INSERT INTO bookmarks (user_id, post_id) 
      VALUES (:user_id, :post_id)");
      $this->db->bind(':user_id', $user_id);
      $this->db->bind(':post_id', $post_id);
      return $this->db->execute();
   }

   public function getBookmarks($user_id) {
      $this->db->query("SELECT * FROM bookmarks
      WHERE user_id = :user_id");
      $this->db->bind(':user_id', $user_id);
      $this->db->execute();
      $rowCount = $this->db->rowCount();
      if($rowCount) {
        return $this->db->getResults();
      } else {
         return false;
      }
   }

   public function getBookmarksAll($user_id) {
      $this->db->query("SELECT b.id, b.user_id, b.post_id, p.title, p.image, p.category_id, p.user_id, u.username, c.name
      FROM bookmarks AS b
      LEFT JOIN posts AS p ON b.post_id = p.id
      LEFT JOIN categories AS c ON p.category_id = c.id
      LEFT JOIN users AS u ON p.user_id = u.id
      WHERE b.user_id = :user_id");
      $this->db->bind(':user_id', $user_id);
      $this->db->execute();
      $rowCount = $this->db->rowCount();
      if($rowCount) {
        return $this->db->getResults();
      } else {
         return false;
      }
   }

   public function removeBookmark($user_id, $post_id) {
      $this->db->query("DELETE FROM bookmarks WHERE user_id = :user_id AND post_id = :post_id");
      $this->db->bind(':user_id', $user_id);
      $this->db->bind(':post_id', $post_id);
      return $this->db->execute();
   }

   public function checkBookmarked($user_id, $post_id) {
      $this->db->query("SELECT * FROM bookmarks WHERE user_id = :user_id AND post_id = :post_id");
      $this->db->bind(':user_id', $user_id);
      $this->db->bind(':post_id', $post_id);
      $this->db->execute();
      $rowCount = $this->db->rowCount();
      if($rowCount) {
         return true;
      } else {
         return false;
      }
   }
 
 }