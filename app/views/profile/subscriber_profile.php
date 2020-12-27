<?php 

  if(isset($data["user"])) {
    $username = $data["user"]["username"];
    $email = $data["user"]["email"];
    $avator = $data["user"]["avator"];
    $id = $data["user"]["id"];
  }
  ?>

<?php include('app/views/inc/head.php') ?>

<header>
 <?php include('app/views/inc/navigation.php') ?>
</header>

<div class="wrapper">
  <div class="user_profile">
    <div class="user_profile_inner">
      <form action="<?php echo URLROOT ?>/profile/update/<?php echo $id ?>" method="post" enctype="multipart/form-data">
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
</div>



<?php include('app/views/inc/footer.php') ?>