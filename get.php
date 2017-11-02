<?php
$con = mysqli_connect("localhost","root","hansung","picture") or die(mysqli_connect_error());
$name = $_REQUEST['name'];
$image = mysqli_query($con, "SELECT * FROM picture WHERE name='$name'");
$image = mysqli_fetch_assoc($image);
$image = $image['data'];
echo $image; 
?>