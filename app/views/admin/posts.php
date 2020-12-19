

<a href="<?php echo URLROOT ?>/admin/index/cposts">
  Create a new post.
</a>
<table>
  <tr>
  
    <th>title</th>
    <th>category</th>
    <th>created By</th>
    <th>status</th>

    <th colspan="3">actions</th>
    </tr>
      <?php 
        if(isset($data["posts"])) {
        foreach($data["posts"] as $post) {
      ?>
    <tr>

    <td>
    <?php

      echo shortenTitle($post->title);
      
    ?>
    </td>
    <td><?php echo $post->name ?></td>
    <td><?php echo $post->username ?></td>
    <td><?php echo $post->status ?></td>
 
    <td><a href="<?php echo URLROOT; ?>/admin/index/uposts/<?php echo $post->id ?>">update</a></td>
    <td><a href="<?php echo URLROOT; ?>/admin/delete/<?php echo $post->id ?>/post" onclick="return confirm('If you delete this article, the comments will be deleted as well. Are you sure you want to delete this article?');">delete</a></td>
    <td><a href="<?php echo URLROOT; ?>/page/post/<?php echo $post->id ?>">visit</a></td>
  </tr>

<?php
 }
}

?>

</table>