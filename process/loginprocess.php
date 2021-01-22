<?php
	session_start();

	include('../conn.php');
	
	$loginem = $_POST['loginem'];
	
	$loginpw = $_POST['loginpw'];
	
	$verify = "SELECT * FROM 1ET_Users WHERE EmailAddress='$loginem' AND Password=MD5('$loginpw')";

	$result = $conn->query($verify);
	
	$num = $result->num_rows;
	
	if($num > 0) {
		
		while($row = $result->fetch_assoc()) {
			$myuser = $row['EmailAddress'];
			$myid = $row['ID'];
			$_SESSION['40130998_user'] = $myuser;
			$_SESSION['40130998_id'] = $myid;
		}
		
		header('location: ../admin/index.php');
	} else {
		header('location: ../login.php');
	}
?>
