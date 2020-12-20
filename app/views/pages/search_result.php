<?php include('app/views/inc/head.php') ?>

  <header>
  <?php include('app/views/inc/navigation.php') ?>
  </header>


  <div class="post_search_page wrapper">

  <ul>
      <?php 
        if(isset($data["posts"])) {

          foreach($data["posts"] as $value) {

            $title = $value->title;
            $author = $value->username;
            $category = $value->name;
            $image = $value->image;
            $id = $value->id;
      ?>

        <li class="post_list">
          <a href="<?php echo URLROOT ?>/page/post/<?php echo $id ?>">
          <div class="post_search flex">
            <div class="post_search_left">
              <div class="img_wrapper">
                <img src="<?php echo URLROOT; ?>/app/views/uploads/<?php echo $image ?>" alt="">
              </div>
            </div>
            <div class="post_search_right">
              <div class="post_detail">
                <p class="category"><?php echo $category ?></p>
                <h2 class="title"><?php echo $title ?></h2>
                <p><?php echo $author?></p>
              </div>
            </div>
          </div>
          </a>
        </li>

      <?php
        }
      } 
    ?>
    </ul>
      
  </div>
 
<?php include('app/views/inc/footer.php') ?>