<?php 

  if(isset($data["error"]) && isset($data["input"])) {
    $err_username = $data["error"]["username"];
    $err_email = $data["error"]["email"];
    $err_password = $data["error"]["password"];
    $err_sec_password = $data["error"]["sec_password"];
    $inp_username = $data["input"]["username"];
    $inp_email = $data["input"]["email"];
    $inp_password = $data["input"]["password"];
    $inp_sec_password = $data["input"]["sec_password"];
  }
?>

<?php include('app/views/inc/head.php') ?>
<h1>SIGNUP PAGE</h1>
<form action="<?php echo URLROOT; ?>/user/signup" method="POST">
  <input type="text" name="username" placeholder="Username" value="<?php echo isset($inp_username) ? "$inp_username" : false?>"><br>
  <?php echo isset($err_username) ? "<p class='alert'>$err_username</p>" : false?>
  <input type="email" name="email" placeholder="Email" value="<?php echo isset($inp_email) ? "$inp_email" : false?>"><br>
  <?php echo isset($err_email) ? "<p class='alert'>$err_email</p>" : false?>
  <input type="password" name="password" placeholder="Password" value="<?php echo isset($inp_password) ? "$inp_password" : false?>"><br>
  <?php echo isset($err_password) ? "<p class='alert'>$err_password</p>" : false?>
  <input type="password" name="sec_password" placeholder="Password Again" value="<?php echo isset($inp_sec_password) ? "$inp_sec_password" : false?>"><br>
  <?php echo isset($err_sec_password) ? "<p class='alert'>$err_sec_password</p>" : false?>
  <?php if(isset($data["error"]["x"])) echo $data["error"]["x"]; ?>
  <input type="submit" value="sign up">
</form>
<?php include('app/views/inc/footer.php') ?>