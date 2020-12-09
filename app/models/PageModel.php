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

   public function getPost($id) {
      $this->db->query("SELECT * FROM posts WHERE id = :id");
      $this->db->bind(":id", $id);
      $this->db->execute();
      return $this->db->getResult();
   }
 
 }