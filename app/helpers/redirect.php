<?php 

  function redirect($path = null) {

    if($path) {
      header("location:" . URLROOT . "/" . $path);
    } else {
      header("location:" . URLROOT);
    }
  
  }

?>