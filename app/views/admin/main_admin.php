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
        <li class="admin_option indent">
          <a href="<?php echo URLROOT?>/admin/index/cposts">- Create</a>
        </li>
        <li class="admin_option">
          <a href="<?php echo URLROOT?>/admin/index/categories">Categories</a>
        </li>
        <li class="admin_option indent">
          <a href="<?php echo URLROOT?>/admin/index/ccategories">- Create</a>
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
           include("app/views/admin/posts.php");
          break;
           case "cposts":
            include("app/views/admin/c_posts.php");
           break;
           case "uposts":
            include("app/views/admin/u_posts.php");
           break;
          case "categories":
            include("app/views/admin/categories.php");
          break;
          case "ccategories":
            include("app/views/admin/c_categories.php");
          break;
          case "comments":
            include("app/views/admin/comments.php");
          break;
          case "users":
           echo "users";
          break;
          default:
           echo "<a href=". URLROOT .">VISIT WEBSITE</a>";
        }
      }
      
      ?>
    </div>
  </div>
</div>
<?php include('app/views/inc/footer.php') ?>