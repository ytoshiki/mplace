<?php 

if(isset($data["error"])) {

    $title_error = $data["error"]["title"];
    $body_error = $data["error"]["body"];
}
?>

<form action="<?php echo URLROOT; ?>/admin/posts" method="POST" enctype="multipart/form-data">
  <input type="text" name="title" placeholder="title"><br>
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
  <textarea name="body" id="" cols="30" rows="10"></textarea><br>
  <?php  echo isset($body_error) ? "<p class='alert'>" . $body_error ."</p>" : false ?>
  <input type="file" name="file"><br>
  <input type="submit" value="submit" name="post">
</form>

