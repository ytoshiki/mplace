<?php 

if(isset($data["error"])) {

    $title_error = $data["error"]["title"];
    $author_error = $data["error"]["author"];
    $body_error = $data["error"]["body"];
}
?>

<form action="<?php echo URLROOT; ?>/admin/posts" method="post">
  <input type="text" name="title" placeholder="title"><br>
  <?php  echo isset($title_error) ? "<p class='alert'>" . $title_error ."</p>" : false ?>
  <input type="text" name="author" placeholder="author"><br>
  <?php  echo isset($author_error) ? "<p class='alert'>" . $author_error ."</p>" : false ?>
  <textarea name="body" id="" cols="30" rows="10"></textarea><br>
  <?php  echo isset($body_error) ? "<p class='alert'>" . $body_error ."</p>" : false ?>
  <input type="file" name="image" placeholder="title"><br>
  <input type="submit" value="submit">
</form>

