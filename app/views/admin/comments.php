<table>
  <tr>
    <th>id</th>
    <th>user_id</th>
    <th>post_id</th>
    <th>comment</th>
    <th colspan="2">actions</th>
  </tr>
  <?php 
  if(isset($data["comments"])) {

  foreach($data["comments"] as $comment) {
  ?>

  <tr>
    <td><?php echo $comment->id ?></td>
    <td><?php echo $comment->user_id ?></td>
    <td><?php echo $comment->post_id ?></td>
    <td><?php echo $comment->comment ?></td>
    <td><a href="<?php echo URLROOT; ?>/admin/delete/<?php echo $comment->id ?>/comment" onclick="return confirm('Are you sure you want to delete this article?');">delete</a></td>
    <td><a href="<?php echo URLROOT; ?>/page/post/<?php echo $comment->post_id ?>">visit</a></td>
  </tr>

<?php
 }
}

?>

</table>