<?php 

  function deleteImage($path, $image) {
    if(file_exists($path . $image)) {
      if(unlink($path . $image)){

        return true;
      } else {
        return false;
      }
    } else {
      return true;
    }
  }

?>