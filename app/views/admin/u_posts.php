<?php 

if(isset($data["posts"])) {
  $id = $data["posts"]["id"];
  $title = $data["posts"]["title"];
  $status = $data["posts"]["status"];
  $body = $data["posts"]["body"];
  $c_id = $data["posts"]["category_id"];
}

if(isset($data["error"])) {

  $title_error = $data["error"]["title"];
  $image_error = $data["error"]["image"];
  $body_error = $data["error"]["body"];
}


?>

<form action="<?php echo URLROOT; ?>/admin/posts/<?php echo $id; ?>" method="post" enctype="multipart/form-data">
  <div class="radio">
    <input type="radio" id="" name="status" value="public" <?php echo $status == "public" ? 'checked' : false?>>
    <label for="">public</label>
    <input type="radio" id="" name="status" value="draft"  <?php echo $status == "draft" ? 'checked' : false?>>
    <label for="">draft</label>
 </div>
  <input type="text" name="title" placeholder="title" value="<?php echo isset($title) ? $title : ""; ?>"><br>
  <?php  echo isset($title_error) ? "<p class='alert'>" . $title_error ."</p>" : false ?>


  <div class="radio">
  <?php 
      if(isset($data["categories"])) {
      foreach($data["categories"] as $category) {
    ?>

    <input type="radio" id="<?php echo $category->name ?>" name="category" value="<?php echo $category->id ?>" <?php echo $category->id == $c_id ? 'checked' : false ?>>
    <label for="<?php echo $category->id ?>"><?php echo $category->name ?></label>
    <?php
      }
    }
    ?>
 </div>
  
  <textarea name="body" id="" cols="30" rows="10"><?php echo isset($body) ? $body : ""; ?></textarea><br>
  <?php  echo isset($body_error) ? "<class='alert'>" . $body_error ."</class=>" : false ?>
  <input type="file" name="file"><br>
  <?php isset($image_error) ? "<class='alert'>" . print_r($image_error) ."</class=>" : false ?>
  <input type="hidden" name="category_id" value='<?php echo $c_id ?>'>
  <input type="submit" value="submit" name="update">
</form>

