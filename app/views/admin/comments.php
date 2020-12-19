<table>
  <tr>
 
    <th>comment</th>
    <th>commented_by</th>
    <th>commented_on</th>
    <th colspan="2">actions</th>
  </tr>
  <?php 
  if(isset($data["comments"])) {

  foreach($data["comments"] as $comment) {
  ?>

  <tr>
  
    <td><?php echo $comment->comment ?></td>
    <td><?php echo $comment->username ?></td>
    <td><?php echo $comment->title ?></td>
    <td><a href="<?php echo URLROOT; ?>/admin/delete/<?php echo $comment->id ?>/comment" onclick="return confirm('Are you sure you want to delete this article?');">delete</a></td>
    <td><a href="<?php echo URLROOT; ?>/page/post/<?php echo $comment->post_id ?>">visit</a></td>
  </tr>

<?php
 }
}

?>

</table>