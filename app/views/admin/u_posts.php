<?php 

if(isset($data["posts"])) {
  $id = $data["posts"]["id"];
  $title = $data["posts"]["title"];
 
  $body = $data["posts"]["body"];
}

if(isset($data["error"])) {

  $title_error = $data["error"]["title"];
  $author_error = $data["error"]["author"];
  $body_error = $data["error"]["body"];
}


?>

<form action="<?php echo URLROOT; ?>/admin/posts/<?php echo $id; ?>" method="post" enctype="multipart/form-data">
  <input type="text" name="title" placeholder="title" value="<?php echo isset($title) ? $title : ""; ?>"><br>
  <?php  echo isset($title_error) ? "<p class='alert'>" . $title_error ."</p>" : false ?>


  <div class="radio">
  <?php 
      if(isset($data["categories"])) {
      foreach($data["categories"] as $category) {
    ?>

    <input type="radio" id="<?php echo $category->name ?>" name="category" value="<?php echo $category->id ?>">
    <label for="<?php echo $category->id ?>"><?php echo $category->name ?></label>
    <?php
      }
    }
    ?>
 </div>
  
  <textarea name="body" id="" cols="30" rows="10"><?php echo isset($body) ? $body : ""; ?></textarea><br>
  <?php  echo isset($body_error) ? "<p class='alert'>" . $body_error ."</p>" : false ?>
  <input type="file" name="file"><br>
  <input type="submit" value="submit" name="update">
</form>

