<?php 
if(isset($data)) {
  
  if(isset($data["post"])) {
    $p_title = $data["post"]["title"];
    $p_id = $data["post"]["id"];
    $p_body = $data["post"]["body"];
    $p_image = $data["post"]["image"];
    $p_username = $data["post"]["username"];
    $p_avator = $data["post"]["avator"];
    $p_category_id = $data["post"]["category_id"];
  } 

  if(isset($data["bookmarked"])) {
    $bookmarked = $data["bookmarked"];
  }

  if(isset($data["widgets"])) {
    $widgets = $data["widgets"];
  }

  if(isset($data["error"])) {
    $error = $data["error"];
  }

}
?>

<?php

  $authenticated = (isset($_SESSION["user_id"]) && isset($_SESSION["user_role"]));
  if($authenticated) {
    $class = "authenticated";
  } else {
    $class = "";
  }
?>

<?php include('app/views/inc/head.php') ?>

  <?php include('app/views/inc/navigation.php') ?>
 
  <div class="single wrapper">
    <div class="single_post">
      <div class="single_post_top">
        <div>
          <?php echo (isset($bookmarked) && $bookmarked) ? 
          "<a href=". URLROOT . "/book/" . $p_id . "/remove class='bookmark_link_sp $class'>Remove Bookmark</a>"
          : 
          "<a href=". URLROOT . "/book/" . $p_id . " class='bookmark_link_sp $class'>Check Bookmark</a>"
          ?>
        </div>
        <h1 class="single_post_top_title">
          <?php  echo $p_title; ?>  
        </h1>
        <div class="single_post_top_author">
          <div class="author_image">
            <img src="<?php echo URLROOT; ?>/app/views/uploads/avators/<?php echo $p_avator; ?>" alt="">
          </div>
          <div>
          <p class="author_name">By <?php echo $p_username;?></p>
          <div class="ahthor_date">December 8, 2020</div>
          
          </div>
      
        </div>
      </div>
      <div class="single_post_bottom">
        <div class="single_post_bottom_content">
          <div class="spb_image">
            <img src="<?php echo URLROOT; ?>/app/views/uploads/posts/<?php echo $p_image ?>" alt="">
          </div>
          <p class="spb_body">
            <?php echo $p_body; ?>
          </p>
        </div>
        <div class="widgets">
          <?php 
            if(isset($widgets)) {
              ?>
                <h3>Articles you might like</h3>
                <ul>
              <?php 
              
              foreach($widgets as $key => $value) {
              ?>
                  <li><a href="<?php echo URLROOT; ?>/page/post/<?php echo $value->id ?>"><?php echo $value->title ?></a></li>

              <?php
              }
              ?>
              </ul>
              <?php
            }
          ?>
        </div>
      </div>
      
    </div>
   
    <div class="comment_display">
      
      <?php 
        if(sizeof($data["comments"])) {

          echo "<h2>Comments</h2>";
          foreach($data["comments"] as $key => $value) {
            ?>
            <div class="comment_display_inner">
              <div class="comment_display_left">
                <div class="img-wrapper">
                  <img src="<?php echo URLROOT ?>/app/views/uploads/avators/<?php echo $value->avator; ?>" alt="">
                  
                </div>
                <p><?php echo $value->username?></p>
              
              </div>
              <div class="comment_display_right">
              <p class="each_comment"><?php echo $value->comment ?></p>
              </div>
            </div>
          
            <?php
          }
        }
      ?>
    </div>
    <div class="comment">
      <div class="comment_inner">
        <h2>Leave a comment</h2>
        <form action="<?php echo URLROOT; ?>/page/comment/<?php echo $p_id ?>" method="post">
          <textarea name="comment" class="comment_input <?php echo isset($_SESSION["user_id"]) && isset($_SESSION["user_role"] ) ? authenticated : false?>" id="" cols="30" rows="10"></textarea><br>
          <?php 
            if(isset($error["comment"])) {
              echo "<p class='alert'>" . $error["comment"] ."</p>";
            }
          ?>
          <input class="comment_submit" type="submit" name="submit" value="send" <?php echo isset($_SESSION["user_id"]) && isset($_SESSION["user_role"]) ? false : "disabled"?>>
          <input type="hidden" name="category_id" value="<?php echo $p_category_id; ?>">
        </form>
      </div>
    </div>
  </div>
<?php include('app/views/inc/footer.php') ?>