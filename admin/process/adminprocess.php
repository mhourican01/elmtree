<?php
	session_start();
	
	if(!isset($_SESSION[''])) {
		header('Location: ../index.php');
	}
	
	$user = $_SESSION[''];
	
	include("../../conn.php");
	
	// promotes profile to admin
	if(isset($_GET["promoteprofile"])) {
		$promoteprofile = $_GET["promoteprofile"];

		$readpromote = "INSERT INTO 1ET_Admin
		(User_ID) VALUES ('$promoteprofile')
		";
		
		$result = $conn->query($readpromote);
		
		if(!$result){
			echo $conn->error;
		}
	}
	
	// deletes profile as admin
	if(isset($_GET["deleteprofile"])) {
		$deleteprofile = $_GET["deleteprofile"];

		$readdelete = "DELETE FROM 1ET_Users
		WHERE ID = '$deleteprofile'";
		 
		echo $readdelete;
		
		$result = $conn->query($readdelete);
		
		if(!$result){
			echo $conn->error;
		}
	}
	
	header('Location: ../index.php');
?>