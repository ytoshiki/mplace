<nav>
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
      if(isset($_SESSION["user_id"]) && $_SESSION["user_role"] !== "admin") {
        ?>

        <li><?php echo $_SESSION["user_name"]; ?></li>
        <li><a href="<?php echo URLROOT; ?>/user/logout" onclick="return confirm('Are you sure you want to log out?');">log out</a></li>
        

        <?php
      } elseif(isset($_SESSION["user_id"]) && $_SESSION["user_role"] == "admin") {
        ?>

        <li><?php echo $_SESSION["user_name"]; ?></li>
        <li><a href="<?php echo URLROOT; ?>/user/logout" onclick="return confirm('Are you sure you want to log out?');">log out</a></li>
        <li><a href="<?php echo URLROOT; ?>/admin/index">edit</a></li>

        <?php
      } else {
        ?>

        
        <li><a href="<?php echo URLROOT; ?>/user/signup">Sign up</a></li>
        <li><a href="<?php echo URLROOT; ?>/user/login">Log in</a></li>
     
        <?php
      }
      ?>
 
    </ul>
    </div>
  </nav>