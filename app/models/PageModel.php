<?php

 class PageModel {

   public function __construct() {
      $this->db = new Database();
   }

   public function getPosts() {
      $this->db->query("SELECT * FROM posts");
      $this->db->execute();
      return $this->db->getResults();
   }

   public function getCategories() {
      $this->db->query("SELECT * FROM categories LIMIT 5");
      $this->db->execute();
      return $this->db->getResults();
   }

   public function getPost($id) {
      $this->db->query("SELECT * FROM posts WHERE id = :id");
      $this->db->bind(":id", $id);
      $this->db->execute();
      return $this->db->getResult();
   }

   public function createComment($data) {
      $this->db->query("INSERT INTO comments (user_id, comment, post_id) VALUES (:user_id, :comment, :post_id)");
      $this->db->bind(":comment", $data["comment"]);
      $this->db->bind(":post_id", $data["post_id"]);
      $this->db->bind(":user_id", $data["user_id"]);
      return $this->db->execute();
   }
 
 }