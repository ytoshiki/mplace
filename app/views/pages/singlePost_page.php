<?php 

  if(isset($data)) {
    $id = $data["id"];
    $title = $data["title"];
    $body = $data["body"];
    $image = $data["image"];
  }
?>

<?php include('app/views/inc/head.php') ?>

  <?php include('app/views/inc/navigation.php') ?>
 
  <div class="single wrapper">
    <div class="single_post">
      <div class="single_post_top">
        <h1 class="single_post_top_title">
          <?php echo $title; ?>
        </h1>
        <div class="single_post_top_author">
          <div class="author_image">
            <img src="<?php echo URLROOT; ?>/app/views/images/user.png" alt="">
          </div>
          <div>
          <p class="author_name">By <?php echo "user"?></p>
          <div class="ahthor_date">December 8, 2020</div>
          
          </div>
      
        </div>
      </div>
      <div class="single_post_bottom">
        <div class="single_post_bottom_content">
          <div class="spb_image">
            <img src="<?php echo URLROOT; ?>/app/views/uploads/<?php echo $image ?>" alt="">
          </div>
          <p class="spb_body">
            <?php echo $body; ?>
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
        <form action="<?php echo URLROOT; ?>/page/comment/<?php echo $id ?>" method="post">
          <textarea name="comment" id="" cols="30" rows="10"></textarea><br>
          <input type="submit" name="submit" value="send">
        </form>
      </div>
    </div>
  </div>
<?php include('app/views/inc/footer.php') ?>