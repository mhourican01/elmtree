<?php
	session_start();
	
	if(!isset($_SESSION[''])) {
		header('Location: ../index.php');
	}
	
	$user = $_SESSION[''];
	$myid = $_SESSION[''];

	include('../../conn.php');

	$newid = $conn->real_escape_string($_POST['newid']);
	$newem = $conn->real_escape_string($_POST['newem']);
	$newpw = $conn->real_escape_string($_POST['newpw']);
	$newpn = $conn->real_escape_string($_POST['newpn']);
	$newli = $conn->real_escape_string($_POST['newli']);
	$newsm = $conn->real_escape_string($_POST['newsm']);
	
	$rand = rand(0, 1000000);
	
	$filename = $_FILES['newimg']['name'];
	$filetmp = $_FILES['newimg']['tmp_name'];
	$filename = $rand.$filename;
	
	move_uploaded_file($filetmp, "../../profileimg/".$filename);

	$reademail = "SELECT EmailAddress FROM 1ET_Users
	WHERE EmailAddress='$newem' AND ID!='$myid'";
	
	$emailresult = $conn->query($reademail);
	
	$dupemail = false;
	
	while($emailrow = $emailresult->fetch_assoc()) {
		$dupemail = true;
		break;
	}
	
	if(!$dupemail) {
		$update = "UPDATE 1ET_Users
		SET EmailAddress = '$newem', 
		Password = MD5('$newpw'), 
		PhoneNumber = '$newpn', 
		LearningInstitute = '$newli', 
		SocialMedia = '$newsm',
		ProfileImg = '$filename'
		WHERE id = '$newid'
		;";
	
		$editresult = $conn->query($update);
	
		if(!$editresult) {
			$conn->error;
		}
		
		header('Location: ../../index.php');
		
	} else {
		header('Location: ../index.php');
	}
?>