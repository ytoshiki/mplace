<table>
  <tr>
  
    <th>username</th>
    <th>email</th>
    <th>avator</th>
    <th>role</th>
    <th colspan="2">actions</th>
  </tr>
  <?php 
  if(isset($data["users"])) {

  foreach($data["users"] as $user) {
  ?>

  <tr>
  
    <td><?php echo $user->username ?></td>
    <td><?php echo $user->email ?></td>
    <td><?php echo $user->avator ?></td>
    <td><?php echo $user->role ?></td>
    <td><a href="<?php echo URLROOT; ?>/admin/delete/<?php echo $user->id ?>/user" onclick="return confirm('If you delete user, all comments and posts by the user will also be deleted. Are you sure you want to delete this user?');">delete</a></td>
    <td><a href="<?php echo URLROOT; ?>/admin/update/<?php echo $user->id ?>/user">update</a></td>
  </tr>

<?php
 }
}

?>

</table>