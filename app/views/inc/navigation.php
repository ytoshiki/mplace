<?php

if(isset($_SESSION["user_role"])) {
  $user_role = $_SESSION["user_role"];
}
?>

<nav class="<?php echo isset($user_role) ? $user_role : "" ?>">
    <div class="nav_inner wrapper">

    
    <div class="logo_container">
      <div class="logo">
        <a href="<?php echo URLROOT; ?>">
          <img src="<?php echo URLROOT; ?>/app/views/images/logo.png" alt="">
        </a>
      </div>
    </div>
    <ul class="main_nav">
      <li>
        <button>
          <div class="svg">
            <img src="<?php echo URLROOT; ?>/app/views/images/search.png" alt="">
          </div>
          <form action="<?php echo URLROOT ?>/page/search" method="GET">
            <input type="text" name="search" placeholder="Search Article" class="search_input">
            <input type="hidden" name="submit">
          </form>
        </button>
      </li>
      <?php 
      if(isset($_SESSION["user_id"]) && $_SESSION["user_role"] == "subscriber") {
        ?>

        <li class="bookmark_nav"><a href="<?php echo URLROOT; ?>/page/bookmark"><div><img src="<?php echo URLROOT ?>/app/views/images/bookmark-red.png" alt="" <?php echo isset($_SESSION["user_id"]) && isset($_SESSION["user_role"] ) ? authenticated : false?>></div></a></li>

        <li><a href="<?php echo URLROOT; ?>/profile/index/<?php echo $_SESSION["user_id"] ?>">profile</a></li>
        <li><a href="<?php echo URLROOT; ?>/user/logout" onclick="return confirm('Are you sure you want to log out?');">log out</a></li>
        
       
        

        <?php
      } elseif(isset($_SESSION["user_id"]) && $_SESSION["user_role"] == "admin") {
        ?>

        <li class="bookmark_nav"><a href="<?php echo URLROOT; ?>/page/bookmark"><div><img src="<?php echo URLROOT ?>/app/views/images/bookmark-red.png" alt="" class="<?php echo isset($_SESSION["user_id"]) && isset($_SESSION["user_role"] ) ? authenticated : false?>"></div></a></li>
        <li>Admin</li>
        <li><a href="<?php echo URLROOT; ?>/user/logout" onclick="return confirm('Are you sure you want to log out?');">log out</a></li>
        <li><a href="<?php echo URLROOT; ?>/admin/index" class="edit_nav">EDIT</a></li>

        <?php
      } else {
        ?>

        <li class="bookmark_nav"><a href="<?php echo URLROOT; ?>/page/bookmark"><div><img src="<?php echo URLROOT ?>/app/views/images/bookmark-red.png" alt="" <?php echo isset($_SESSION["user_id"]) && isset($_SESSION["user_role"] ) ? authenticated : false?>></div></a></li>
        <li><a href="<?php echo URLROOT; ?>/user/signup">Sign up</a></li>
        <li><a href="<?php echo URLROOT; ?>/user/login">Log in</a></li>
     
        <?php
      }
      ?>
 
    </ul>
    </div>
  </nav>