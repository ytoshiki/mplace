<?php 

  if(isset($data["error"])) {
    $err_first = $data["error"]["first_row"];
    $err_second = $data["error"]["second_row"];
  }
?>

<?php include('app/views/inc/head.php') ?>
<h1>LOGIN PAGE</h1>
<form action="<?php echo URLROOT; ?>/user/login" method="POST">

  <input type="text" name="username_email" placeholder="Username or Email"><br>
  <?php echo isset($err_first) ? "<p class='alert'>$err_first</p>" : false?>
  
  <input type="password" name="password" placeholder="Password"><br>
  <?php echo isset($err_second) ? "<p class='alert'>$err_second</p>" : false?>

  <?php if(isset($data["error"]["result"])) echo "<p class='alert'>" . $data["error"]["result"]. "</p>" ; ?>

  <input type="submit" value="log in">
</form>
<?php include('app/views/inc/footer.php') ?>