<?php

if($_POST){
    $path = $_FILES['image']['name'];
$ext = pathinfo($path, PATHINFO_EXTENSION);
}
?>

<form action="" method="POST">
<input type="file" class="form-control" name="image" id="image">
 
    <input type="submit" value="Enviar">
</form>