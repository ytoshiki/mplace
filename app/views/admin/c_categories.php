<?php 

if(isset($data["error"])) {

    $name_error = $data["error"]["name"];
   
}
?>

<form action="<?php echo URLROOT; ?>/admin/categories" method="POST">
  <input type="text" name="name" placeholder="name"><br>
  <?php  echo isset($name_error) ? "<p class='alert'>" . $name_error ."</p>" : false ?>
  <input type="submit" value="submit" name="post">
</form>

