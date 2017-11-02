<?php
 $con=mysqli_connect("localhost","root","hansung","picture");
 // Check connection
 $id = $_POST['vid'];
 
 if(unlink($id)){
 	echo "delete!";
}else{
	echo "삭제 실패";
}
 
 if (mysqli_connect_errno())
   {
   echo "Failed to connect to MySQL: " . mysqli_connect_error();
   }else{
	   mysqli_query($con,"DELETE FROM video WHERE name='$id'");
	    header("Location: config.php");
   }


 mysqli_close($con);

 
  

 ?> 