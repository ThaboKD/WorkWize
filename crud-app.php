<?php
	include("conn.php");

	function clean($str) {
		$str = @trim($str);
		if(get_magic_quotes_gpc()) {
			$str = stripslashes($str);
		}
		return mysql_real_escape_string($str);
	}
							
	if (!isset($_FILES['image']['tmp_name'])) {
		echo " ";
	}else{
		$file=$_FILES['image']['tmp_name'];
		$image = $_FILES["image"] ["name"];
		$image_name= addslashes($_FILES['image']['name']);
		$size = $_FILES["image"] ["size"];
		$error = $_FILES["image"] ["error"];
		$extension = explode('.', $image);
		$extension = end($extension);
		$set='123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ_-';
		$randX = substr(str_shuffle($set), 0, 11);
		$dy = date("YmdHis");
		$random_name = $dy."_".$randX;
							
		if($size > 10000000){
			die("Format is not allowed or file size is too big!");
		}else{
			move_uploaded_file($_FILES["image"]["tmp_name"],"upload/".$random_name.".".$extension);
			$location="upload/".$random_name.".".$extension;
			$lo="upload/";
			$user=clean($_POST['user']);
			$content=clean($_POST['status']);
			$time=time();
			
			if(!empty($file) && !empty($image)){
	            $update=mysql_query(" INSERT INTO post (user_id, post_image, content, created) VALUES ('$user','$location','$content','$time') ") or die (mySQL_error());
	            header("location: index.php");
	        }else{
	            $update=mysql_query(" INSERT INTO post (user_id, post_image, content, created)
				VALUES ('$user','$lo','$content','$time') ") or die (mySQL_error());
				header("location: index.php");
	        }						
		}
	}
?>
