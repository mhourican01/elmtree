<?php
	session_start();
	
	if(!isset($_SESSION[''])) {
		header('Location: ../index.php');
	}
	
	$user = $_SESSION[''];
	
	include("../../conn.php");
	
	// deletes ad as seller
	if(isset($_GET["deleteid"])) {
		$deleteid = $_GET["deleteid"];

		$delete = "DELETE FROM 1ET_Items 
		WHERE item_id = '$deleteid'";
		
		$result = $conn->query($delete);
		
		if(!$result){
			echo $conn->error;
		}
	}	
	
	header('Location: ../index.php');
?>