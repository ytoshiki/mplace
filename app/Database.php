<?php

  class Database {
    private $db;
    private $error;
    private $stmt;

    public function __construct() {

      try {
        $this->db = new PDO("mysql:host=localhost;dbname=mplace;port=3307", "root", "y7d4RFWY");
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

      } catch (PDOExecption $ex) {
        $this->error = $ex->getMessage();
        echo $this->error;
      }


    }
  }
?>