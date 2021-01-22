<?php

	session_start();
	
	if(!isset($_SESSION[''])) {
		header('Location: ../index.php');
	}
	
	$user = $_SESSION[''];
	$senderid = $_SESSION[''];
	
	include("../../conn.php");
	
	$msg = $conn->real_escape_string($_POST["message"]);
	
	if(isset($_GET['receiver'])){
		$receiverid = $_GET['receiver'];
	}

	$insert = "INSERT into 1ET_Messages 
	(Sender, Receiver, Message, Date)
	VALUES ('$senderid', '$receiverid', '$msg', CURRENT_TIMESTAMP())";
	
	$result = $conn->query($insert);
	
	if(!$result) {
		$conn->error;
	}
	
	header('Location: ../index.php');
?>