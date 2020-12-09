<?php include('app/views/inc/head.php') ?>
<div class="admin">
  <div class="admin_left">
    <div class="admin_left_inner">
      <ul class="admin_options">
        <li class="admin_option">
          <a href="<?php echo URLROOT?>/admin/index">Dashboard</a>
        </li>
        <li class="admin_option">
          <a href="<?php echo URLROOT?>/admin/index/posts">Posts</a>
        </li>
        <li class="admin_option">
          <a href="<?php echo URLROOT?>/admin/index/cposts">Create</a>
        </li>
        <li class="admin_option">
          <a href="<?php echo URLROOT?>/admin/index/categories">Categories</a>
        </li>
        <li class="admin_option">
          <a href="<?php echo URLROOT?>/admin/index/comments">Comments</a>
        </li>
        <li class="admin_option">
          <a href="<?php echo URLROOT?>/admin/index/users">Users</a>
        </li>
      </ul>
    </div>
  </div>
  <div class="admin_right">
    <div class="admin_right_inner">

      <?php 
        if(isset($data["display"])) {

          $display_page = $data["display"];

        switch($display_page) {
          case "posts":
           echo "posts";
          break;
           case "cposts":
            include("app/views/admin/c_post.php");
           break;
          case "categories":
            echo "categories";
          break;
          case "comments":
            echo "comments";
          break;
          case "users":
           echo "users";
          break;
          default:
           echo "hey world";
        }
      }
      
      ?>
    </div>
  </div>
</div>
<?php include('app/views/inc/footer.php') ?>