


<div class="news_content wrapper <?php echo isset($_SESSION["user_id"]) ? 'auth_set' : ''?>">
  <div class="news_content_inner">

    <ul class="news_nav flex_ai_c">
    <?php 
      if(isset($data["categories"])) {

      foreach($data["categories"] as $value) {
      $name = $value->name;
      $id = $value->id;
      ?>

      <li><a href="<?php echo URLROOT; ?>/page/filter/<?php echo $id ?>"><?php echo $name; ?></a></li>

      <?php 
      }}
      ?>
    </ul>


    <ul class="articles flex">
    <?php 
      
      if(isset($data["posts"])) {

        foreach($data["posts"] as $value) {
          $title = $value->title;
          $author = $value->username;
          $image = $value->image;
          $id = $value->id;
      ?>


          <li class="article">
          <div class="article_top" style="background: url('<?php echo URLROOT; ?>/app/views/uploads/<?php echo $image ?>');">
            <div class="article_title">
            <a href="<?php echo URLROOT ?>/page/post/<?php echo $id ?>">
              <?php echo $title; ?>
              </a>
            </div>
          </div>
          <div class="article_bottom">
            <div class="article_author">
              <p><?php echo "Written By " . $author; ?></p>
            </div>
            <div class="article_func">
              <div class="article_fav">
              <i class="far fa-heart"></i>
              </div>
              <div class="article_share">
              <i class="fas fa-share"></i>
              </div>
              <div class="article_comments">
              <i class="far fa-comment-dots"></i>
              </div>
            </div>
          </div>
        </li>

      <?php
        }
      } 
    ?>

    </ul>
    <?php if(isset($data["readmore"])) {
      ?>

      <div class="article_read_wrapper">
        <button class="article_read">
          <a href="<?php echo URLROOT ?>/page/index/all">
          Read more
          </a>
        </button>
      </div>

      <?php
    } 
    ?>
    
 
  </div>
</div>