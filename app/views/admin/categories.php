<a href="<?php echo URLROOT ?>/admin/index/ccategories">
  Create a new category.
</a>

<table>
  <tr>
   
    <th>category</th>
    <th>status</th>
    <th colspan="2">actions</th>
  </tr>
  <?php 
  if(isset($data["categories"])) {

  foreach($data["categories"] as $category) {
  ?>

  <tr>
 
    <td><?php echo $category->name ?></td>
    <td><?php echo $category->status ?></td>
    <td><a href="<?php echo URLROOT; ?>/admin/status/<?php echo $category->id ?>/category" onclick="return confirm('Are you sure you want to change the status?');">change_status</a></td>
    <td><a href="<?php echo URLROOT; ?>/admin/delete/<?php echo $category->id ?>/category" onclick="return confirm('If you delete category, all posts and comments associated with the category will also be deleted. Are you sure you want to delete this category?');">delete</a></td>
  </tr>

<?php
 }
}

?>

</table>