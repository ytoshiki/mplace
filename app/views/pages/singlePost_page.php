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
}
?>

<?php include('app/views/inc/head.php') ?>

  <?php include('app/views/inc/navigation.php') ?>
 
  <div class="single wrapper">
    <div class="single_post">
      <div class="single_post_top">
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
            <img src="<?php echo URLROOT; ?>/app/views/uploads/<?php echo $p_image ?>" alt="">
          </div>
          <p class="spb_body">
            <?php echo $p_body; ?>
          </p>
        </div>
        <div class="widgets">
          <h2>Trending</h2>
          <ul>
            <li>1</li>
            <li>2</li>
            <li>3</li>
          </ul>
        </div>
      </div>
      
    </div>
    <div class="comment">
      <div class="comment_inner">
        <form action="<?php echo URLROOT; ?>/page/comment/<?php echo $p_id ?>" method="post">
          <textarea name="comment" id="" cols="30" rows="10"></textarea><br>
          <input type="submit" name="submit" value="send">
          <input type="hidden" name="category_id" value="<?php echo $p_category_id; ?>">
        </form>
      </div>
    </div>
    <div class="comment_display">
      <h1>Comment</h1>
      <?php 
        if(isset($data["comments"])) {
        
          foreach($data["comments"] as $key => $value) {
            ?>

            <p class="each_comment"><?php echo $value->comment ?><br><?php echo $value->username?></p>

            <?php
          }
        }
      ?>
    </div>
  </div>
<?php include('app/views/inc/footer.php') ?>