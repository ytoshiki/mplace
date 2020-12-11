<a href="<?php echo URLROOT ?>/admin/index/ccategories">
  Create a new category.
</a>

<table>
  <tr>
    <th>id</th>
    <th>category</th>
    <th>action</th>
  </tr>
  <?php 
  if(isset($data["categories"])) {

  foreach($data["categories"] as $category) {
  ?>

  <tr>
    <td><?php echo $category->id ?></td>
    <td><?php echo $category->name ?></td>
    <td><a href="<?php echo URLROOT; ?>/admin/delete/<?php echo $category->id ?>/category" onclick="return confirm('Are you sure you want to delete this category?');">delete</a></td>
  </tr>

<?php
 }
}

?>

</table>