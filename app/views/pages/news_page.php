<div class="news_content wrapper">
  <div class="news_content_inner">
    <ul class="news_nav flex_ai_c">
      <li><a href="" class="active">Latest</a></li>
      <li><a href="">Featured</a></li>
      <li><a href="">News</a></li>
      <li><a href="">Tech</a></li>
      <li><a href="">Sport</a></li>
     
    </ul>
    <ul class="articles flex">


    <?php 
      
      if(isset($data)) {
        foreach($data as $value => $key) {

          $title = $key["title"];
          $author = $key["author"];
          $image = $key["image"];
          $id = $key["id"];
      ?>


          <li class="article">
          <div class="article_top" style="background: url('app/views/images/<?php echo $image ?>.jpg');">
            <div class="article_title">
            <a href="<?php echo URLROOT ?>/page/post/<?php echo $id ?>">
              <?php echo $title; ?>
              </a>
            </div>
          </div>
          <div class="article_bottom">
            <div class="article_author">
              <p><?php echo $author; ?></p>
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
    <div class="article_read_wrapper">
    <button class="article_read">
      Read more
    </button>
    </div>

  </div>
</div>