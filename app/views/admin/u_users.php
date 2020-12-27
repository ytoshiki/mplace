<h1>Update User Here</h1>
<?php 
  if($data["users"]) {
    
    $user = $data["users"];
    $role = $user["role"];
    $id = $user["id"];
    $avator = $user["avator"];
    $email = $user["email"];
    $username = $user["username"];
  } 

?>

  <div class="user_profile">
    <div class="user_profile_inner">
      <form action="<?php echo URLROOT ?>/admin/update/<?php echo $id ?>" method="post" enctype="multipart/form-data">
        <div class="profile_image">
          <div class="image_wrapper">
            <img src="<?php echo URLROOT; ?>/app/views/uploads/avators/<?php echo $avator ?>" class="avator" alt="">
          </div>
        </div>
        <div class="image_edit">
        <input type="file" name="file">
        <img src="<?php echo URLROOT; ?>/app/views/images/edit.png" alt="" class="edit">
        </div>
        <div>
          <label for="role">Role</label><br>
          <input type="radio" id="admin" name="role" value="admin" <?php echo ($role == "admin") ? 'checked' : 'false'?>>
          <label for="male">admin</label>
          <input type="radio" id="subscriber" name="role" value="subscriber" <?php echo ($role == "subscriber") ? 'checked' : 'false'?>>
          <label for="female">subscriber</label> 
        </div>
        <div>
          <label for="username">Username</label><br>
          <input type="text" name="username" value="<?php echo $username ?>"><br>
          <?php echo isset($data["error"]["username"]) ? "<p class='alert'>".$data["error"]["username"]. "</p>" : false?>
        </div>
        <div>
          <label for="email">Email</label><br>
          <input type="email" name="email" value="<?php echo $email ?>">
          <?php echo isset($data["error"]["email"]) ? "<p class='alert'>".$data["error"]["email"]. "</p>" : false?>
        </div>
        <input type="submit" value="Update Profile" name="submit">
      </form>
    </div>
  </div>

