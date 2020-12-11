

<a href="<?php echo URLROOT ?>/admin/index/cposts">
  Create a new post.
</a>
<table>
  <tr>
    <th>id</th>
    <th>category</th>
    <th>user</th>
    <th>title</th>
    <th colspan="3">actions</th>
  </tr>
  <?php 

if(isset($data["posts"])) {

  print_r($data["posts"]);

 foreach($data["posts"] as $post) {
?>

  <tr>
    <td><?php echo $post->id ?></td>
    <td><?php echo $post->name ?></td>
    <td><?php echo $post->username ?></td>
    <td><?php echo $post->title ?></td>
    <td><a href="<?php echo URLROOT; ?>/admin/index/uposts/<?php echo $post->id ?>">update</a></td>
    <td><a href="<?php echo URLROOT; ?>/admin/delete/<?php echo $post->id ?>/post" onclick="return confirm('Are you sure you want to delete this article?');">delete</a></td>
    <td><a href="<?php echo URLROOT; ?>/page/post/<?php echo $post->id ?>">visit</a></td>
  </tr>

<?php
 }
}

?>

</table>