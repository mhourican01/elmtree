<?php
	
	session_start();
	
	if(!isset($_SESSION[''])) {
		header('Location: ../index.php');
	}

	$user = $_SESSION[''];
	
	include("../../conn.php");

	$newid = $conn->real_escape_string($_POST['newid']);
	$newtitle = $conn->real_escape_string($_POST['newtitle']);
	$newprice = $conn->real_escape_string($_POST['newprice']);
	$newgender = $conn->real_escape_string($_POST['newgender']);
	$newsize = $conn->real_escape_string($_POST['newsize']);
	$newsport = $conn->real_escape_string($_POST['newsport']);
	$newblurb = $conn->real_escape_string($_POST['newblurb']);
	$hidenew = $conn->real_escape_string($_POST['hidenew']);

	$update = "UPDATE 1ET_Items
	SET Name = '$newtitle', 
	Price = '$newprice', 
	gender_id = '$newgender', 
	Size = '$newsize', 
	Sport = '$newsport', 
	Blurb = '$newblurb',
	Visibility = '$hidenew' 
	WHERE item_id = '$newid'
	;";

	$editresult = $conn->query($update);
	
	if(!$editresult) {
		$conn->error;
	}
	
	$rand = rand(0, 1000000);
	
	$totalfilesnum = count($_FILES['newimg']['name']);
	
	if($totalfilesnum > 0) {
		
		$deleteimg = "DELETE FROM 1ET_Gallery 
			WHERE item_id='$newid';
		";
		
		$resultdeleteimg = $conn->query($deleteimg);
		
		for($i=0; $i < $totalfilesnum; $i++) {
			$tmploc = $_FILES['newimg']['tmp_name'][$i];
			$filename = $_FILES['newimg']['name'][$i];
			$filename = $rand.$filename;
			
			move_uploaded_file($tmploc, "../../itemimg/".$filename);
			
			$editimg = "INSERT INTO 1ET_Gallery 
			(item_id, path) VALUES 
			('$newid', '$filename');
			"; 
			
			$resulteditimg = $conn->query($editimg);
		}
	}
	
	header('Location: ../index.php');
?>