<?php

	session_start();
	
	if(!isset($_SESSION[''])) {
		header('Location: ../index.php');
	}
	
	$user = $_SESSION[''];
	$myid = $_SESSION[''];
	
	include("../../conn.php");
	
	
	if(isset($_GET['buyitem'])){
		$buyitem = $_GET['buyitem'];
	
		$buyer = $conn->real_escape_string($_POST["buyer"]);
		$seller = $conn->real_escape_string($_POST["seller"]);
		
		$getbuyer = "SELECT ID From 1ET_Users
		WHERE EmailAddress = '$buyer';
		";
		
		$getbuyerresult = $conn->query($getbuyer);
		
		while($getbuyerrow=$getbuyerresult->fetch_assoc()) {
			$thebuyer = $getbuyerrow['ID'];
		}
		
		$insert = "INSERT into 1ET_Exchanges 
		(Item, Seller, SelectedBuyer, ConfirmedBuyer)
		VALUES ('$buyitem', '$seller', '$thebuyer', NULL)";
		
		$result = $conn->query($insert);
		
		if(!$result) {
			$conn->error;
		}
	}
	
	if(isset($_GET['confitem'])){
		$confitem = $_GET['confitem'];
	
		$confirmbuyer = $conn->real_escape_string($_POST["confirmbuyer"]);

		$readconfirmbuyer = "SELECT ID From 1ET_Users
		WHERE EmailAddress = '$confirmbuyer';
		";
		
		$confirmbuyerresult = $conn->query($readconfirmbuyer);
		
		while($confbuyerrow=$confirmbuyerresult->fetch_assoc()) {
			$confbuyer = $confbuyerrow['ID'];
		}
		
		$confinsert = "UPDATE 1ET_Exchanges  
		SET ConfirmedBuyer='$confbuyer' 
		WHERE Item='$confitem';
		";

		$confresult = $conn->query($confinsert);
		if(!$confresult) {
			$conn->error;
		}
	}
	
	if(isset($_GET['rateseller'])){
		$rateseller = $_GET['rateseller'];
	
		$rating = $conn->real_escape_string($_POST["rating"]);

		$rateupdate = "UPDATE 1ET_Exchanges  
		SET Rating='$rating' 
		WHERE Seller='$rateseller';
		";
		
		$updateresult = $conn->query($rateupdate);
		if(!$updateresult) {
			$conn->error;
		}
	}
	
	header('Location: ../index.php');
?>