<?php

	$conn = new mysqli('', '', '', '');

	if($conn->connect_error) {
		echo $conn->connect_error;
	}
?>