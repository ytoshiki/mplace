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

    public function query($query) {
      $this->stmt = $this->db->prepare($query);
    }

    public function bind($param, $value) {
  
        $option = null;

        switch(true) {
          case is_numeric($value):
            $option = PDO::PARAM_INT;
          break;
          case is_bool($value):
            $option = PDO::PARAM_BOOL;
          break;
          case is_null($value):
            $option = PDO::PARAM_NULL;
          break;
          default :
            $option = PDO::PARAM_STR;
        }
        
        $this->stmt->bindValue($param, $value, $option);
    }

    public function execute() {
      return $this->stmt->execute();
    }

    public function getResult() {
      return $this->stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getResultsArr() {
      return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getResults() {
      return $this->stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function rowCount() {
      return $this->stmt->rowCount();
    }

  }
?>