<!doctype html>
<html lang="ko">
  <head>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

    <meta charset="utf-8">
    <title>1494027 이건녕/1494022 서정민</title>
    <style>
      #jb-container {
	color :white;
        width: 960px;
        margin: 0px auto;
        padding: 10px;
        border: 1px solid #bcbcbc;
	background : black;
      }
      #jb-header {
	
        padding: 5px;
        margin-bottom: 5px;
        border: 1px solid #bcbcbc;
      }
      #jb-content1 {
        width: 580px;
	height:300px;
        padding: 10px;
        margin-bottom: 5px;
        float: left;
        border: 1px solid #bcbcbc;
      }
	  #jb-sidebar1 {
        width: 330px;
	overflow:scroll;
	height:300px;
        padding: 10px;
        margin-bottom: 5px;
        float: right;
        border: 1px solid #bcbcbc;
      }
	  #jb-content2 {
        width: 580px;
	height:300px;
        padding: 10px;
        margin-bottom: 5px;
        float: left;
        border: 1px solid #bcbcbc;
      }
      #jb-sidebar2 {
        width: 330px;
	overflow:scroll;
	height:300px;
        padding: 10px;
        margin-bottom: 5px;
        float: right;
        border: 1px solid #bcbcbc;
      }
      #jb-footer {
        clear: both;
        padding: 10px;
        border: 1px solid #bcbcbc;
      }
    </style>
  </head>
  <body>
  <?php
 $con=mysqli_connect("localhost","root","hansung","picture");

 if (mysqli_connect_errno())
   {
   echo "Failed to connect to MySQL: " . mysqli_connect_error();
   }

 $result = mysqli_query($con,"SELECT * FROM picture");
$result2 = mysqli_query($con,"SELECT * FROM video");
?>
  
  
  
    <div id="jb-container">
      <div id="jb-header">
        <h1>스마트프로덕트 설계 프로젝트 - IP카메라 만들기</h1>
      </div>
      <div id="jb-content1">
       
		<?php
		$image_name =addslashes($_REQUEST['picture']);
  echo "<img width='400' height='300' src='get.php?name=$image_name'>";
		?>
		
         </div>
	  <div id="jb-sidebar1">
        <h3>캡쳐 목록</h3>
		
       <form method = "post" action = "config.php">
  Select Image: <br>
<input type = "text" name = "picture" value = "<?php echo $_POST['name']?>">
  <input type = "submit" value = "확인">
</form>
<?php
 echo "<table border='1'>
 <tr>

 <th>NAME</th>

 <th>DELETE</th>
 </tr>";

 while($row = mysqli_fetch_array($result))
   {
   echo "<tr>";
?>
<form action="./config.php" method="post">
<?php
	
   echo "<td>"  ?><button name='name' value='<?php echo $row['name']?>'><?php echo $row['name']?></button><?php "</td>";?>
  
  </form>
  
  <form action="./picture_delete.php" method="post">
  <?php
    echo "<td align='center'>"  ?><button name='id' value='<?php echo $row['id']?>'>delete</button> <?php "</td>";
   ?>
   </form>
   <?php
   echo "</tr>";
   }
 echo "</table>";

 mysqli_close($con);

 
 ?> 


      </div>

	<?php $videoname =addslashes($_REQUEST['videoname']);?>


	  <div id="jb-content2">
       
		<video id="myvideo" width="400" height="300" controls autoplay loop>
 			 <source src="<?php echo $videoname ?>" type='video/mp4'>
			<source src="<?php echo $videoname ?>" type='video/ogg'>
		</video>


           </div>



      <div id="jb-sidebar2">
        <h3>모션 검출 목록 </h3>
	<h4>모션 검출 개수 : <?php $num = mysqli_num_rows($result2); echo $num/2;?></h4>
       <?php
 		echo "<table border='1'>
 	<tr>

 	<th>NAME</th>
 	<th>DELETE</th>
	 </tr>";

 while($row = mysqli_fetch_array($result2))
   {
  	 echo "<tr>";
		?>
<form action="./config.php" method="post">
<?php
	
   echo "<td>"  ?><button name='videoname' value='<?php echo $row['name']?>'><?php echo $row['name']?></button><?php "</td>";?>
  
  </form>
  
  <form action="./video_delete.php" method="post">
  <?php
    echo "<td align='center'>"  ?><button name='vid' value='<?php echo $row['name']?>'>delete</button> <?php "</td>";
   ?>
   </form>
   <?php
   echo "</tr>";
   }
 echo "</table>";

 mysqli_close($con);

 
 ?> 
      </div>
      <div id="jb-footer">
        <p>Copyright: 이건녕&서정민       <a href="#" onclick='location.reload(true); return false;'>새로고침</a></p>
	
      </div>
    </div>
  </body>
</html>