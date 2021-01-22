<?php
	include("../conn.php");
	
	$userem = $conn->real_escape_string($_POST["userem"]);
	$userpw = $conn->real_escape_string($_POST["userpw"]);
	$userpn = $conn->real_escape_string($_POST["userpn"]);
	$userln = $conn->real_escape_string($_POST["userln"]);
	$usersm = $conn->real_escape_string($_POST["usersm"]);
	
	$rand = rand(0, 1000000);	
	$filename = $_FILES['userpic']['name'];
	$filetmp = $_FILES['userpic']['tmp_name'];
	
	$filename = $rand.$filename;
	
	move_uploaded_file($filetmp, "../profileimg/".$filename);
	
	$reademail = "SELECT EmailAddress FROM 1ET_Users
	WHERE EmailAddress='$userem'";
	
	$emailresult = $conn->query($reademail);
	
	$dupemail = false;
	
	while($emailrow = $emailresult->fetch_assoc()) {
		$dupemail = true;
		break;
	}
	
	if(!$dupemail) {
			$insert = "INSERT into 1ET_Users 
			(EmailAddress, Password, PhoneNumber, LearningInstitute, SocialMedia, ProfileImg)
			VALUES ('$userem', MD5('$userpw'), '$userpn', '$userln', '$usersm', '$filename')";
			$result = $conn->query($insert);
			
			if(!$result){
				echo $conn->error;
				
			}
			
			header('Location: ../login.php');
	} else {
		header('Location: ../register.php');
	}
?>