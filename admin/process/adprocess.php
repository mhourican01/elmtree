<?php

	session_start();
	
	if(!isset($_SESSION[''])) {
		header('Location: ../index.php');
	}

	$user = $_SESSION[''];
	
	include("../../conn.php");
	
	$shoename = $conn->real_escape_string($_POST["shoename"]);
	$shoeprice = $conn->real_escape_string($_POST["shoeprice"]);
	$shoegender = $conn->real_escape_string($_POST["shoegender"]);
	$shoesize = $conn->real_escape_string($_POST["shoesize"]);
	$shoesport = $conn->real_escape_string($_POST["shoesport"]);
	$shoeblurb = $conn->real_escape_string($_POST["shoeblurb"]);
	$seller = $conn->real_escape_string($_POST["seller"]);
	$hideitem = $conn->real_escape_string($_POST["hideitem"]);
	
	$insert = "INSERT into 1ET_Items 
	(Name, Price, gender_id, Size, Sport, Blurb, Seller, Date, Visibility)
	VALUES ('$shoename', '$shoeprice', '$shoegender', '$shoesize', 
	'$shoesport', '$shoeblurb', '$seller', CURRENT_TIMESTAMP(), '$hideitem')";
		
	
	$result = $conn->query($insert);
	
	if(!$result){
		echo $conn->error;
	}
	
	$item_id = $conn->insert_id;
	
	$rand = rand(0, 1000000);	
	
	$totalfilesnum = count($_FILES['itemimg']['name']);
	
	if($totalfilesnum > 0) {
		
		for($i=0; $i < $totalfilesnum; $i++) {
			$tmploc = $_FILES['itemimg']['tmp_name'][$i];
			$filename = $_FILES['itemimg']['name'][$i];
			$filename = $rand.$filename;
			
			move_uploaded_file($tmploc, "../../itemimg/".$filename);
		
			$insertimg = "INSERT INTO 1ET_Gallery (item_id, path) VALUES ('$item_id', '$filename')"; 
			
			$resultimginsert = $conn->query($insertimg);
		}
	}
	
	header('Location: ../index.php');
?>