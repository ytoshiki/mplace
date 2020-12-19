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
 
 }