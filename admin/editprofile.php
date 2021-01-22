<?php
	session_start();
	
	if(!isset($_SESSION[''])) {
		header('Location: ../index.php');
	}

	$user = $_SESSION[''];

	include("../conn.php");
	
	// selects user data for navbar
	$readuser = "SELECT * FROM 1ET_Users
	WHERE EmailAddress='$user';
	";
	
	$userresult = $conn->query($readuser);
	
	if (!$userresult) {
		$conn->error;
	}

	$row = $conn->real_escape_string($_GET['editid']);
  
	$readrow = "SELECT * FROM 1ET_Users
	WHERE id ='$row';";
  
	$result = $conn->query($readrow);
	
	if(!$result) {
		echo $conn->error;
	}
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Elmtree | Connecting Students</title>
	
	<link rel="stylesheet" href="../styles/gui.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.4/css/bulma.min.css"/>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
	<script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>
  </head>
  
	<body>
		<section class="hero is-primary">
			<div class="hero-head">
				<nav class="navbar">
					<div class="container">
						<div class="navbar-brand">
							<a class="navbar-item" href="index.php">
								<p class='title'>Elmtree</p>
							</a>
							<span class="navbar-burger burger" data-target="navbarMenuHeroA">
								<span></span>
								<span></span>
								<span></span>
							</span>
						</div>
						<div id="navbarMenuHeroA" class="navbar-menu">
							<div class="navbar-end">
								<a class="navbar-item is-active" href="advertise.php">
									Advertise
								</a>

								<?php
									// user data for navbar
									while($userrow = $userresult->fetch_assoc()) {
										$userid = $userrow['ID'];
										$useremail = $userrow['EmailAddress'];
										echo "
										<nav class='navbar' role='navigation' aria-label='dropdown navigation'>
										  <div class='navbar-item has-dropdown is-hoverable'>
											<a class='navbar-link'>
											  $useremail
											</a>

											<div class='navbar-dropdown'>
												<a class='dropdown-item' href='myprofile.php?userid=$userid'>
													Profile
												</a>
												<a class='dropdown-item' href='inbox.php?myinbox=$userid' class='navbar-item'>
													Inbox
												</a>
												<a class='dropdown-item' href='outbox.php?myoutbox=$userid' class='navbar-item'>
													Outbox
												</a>
												<a class='dropdown-item' href='sortby.php?mybuy=$userid' class='navbar-item'>
													Purchases
												</a>
												<a class='dropdown-item' href='sortby.php?mysold=$userid' class='navbar-item'>
													Sales
												</a>
												<a class='dropdown-item' href='sortby.php?mysell=$userid' class='navbar-item'>
													Advertisements
												</a>
												<a class='dropdown-item' href='../index.php' class='navbar-item'>
													Logout
												</a>
											</div>
										  </div>
										</nav>
										 ";
									}
								?>
							</div>
						</div>
					</div>
				</nav>
			</div>

			<div class="hero-body">	
				<div class="container has-text-centered">
					<a href="index.php">
						<img src="../webimg/icon.png" class="ctrimg">
					</a>
					<h2 class="subtitle">
						Connecting Students
					</h2>
				</div>
			</div>

			<!--categories in footer-->
			<div class="hero-foot">
				<div class="columns">
				
					<!--sort by price-->
					<div class="column is-two">
						<nav class="navbar" role="navigation" aria-label="dropdown navigation">
							<div class="navbar-item has-dropdown is-hoverable">
								<a class="navbar-link">
									Price
								</a>

								<div class="navbar-dropdown">
									<?php
										echo "<a class='dropdown-item' href='sortby.php?lowestprice' class='navbar-item'>
											Lowest
										</a>
										<a class='dropdown-item' href='sortby.php?highestprice' class='navbar-item'>
											Highest
										</a>
										";
									?>
								</div>
							</div>
						</nav>
					</div>
				
					<!--gender category-->
					<div class="column is-two">
						<nav class="navbar" role="navigation" aria-label="dropdown navigation">
							<div class="navbar-item has-dropdown is-hoverable">
								<a class="navbar-link">
									Gender
								</a>

								<div class="navbar-dropdown">
									<?php
										$readgender = "SELECT * FROM 1ET_Gender";
										$genderresult = $conn->query($readgender);
										if(!$genderresult) {
											echo $conn->error;
										}
										while ($genderrow = $genderresult->fetch_assoc()) {
											
											$genderid = $genderrow['ID'];
											$gender = $genderrow['Gender'];
									
											echo "<a class='dropdown-item' href='sortby.php?gender=$genderid' class='navbar-item'>
												$gender
											</a>
											";
										}
									?>
								</div>
							</div>
						</nav>
					</div>
					
					<!--size category-->
					<div class="column is-two">
						<nav class="navbar" role="navigation" aria-label="dropdown navigation">
							<div class="navbar-item has-dropdown is-hoverable">
								<a class="navbar-link">
									Size
								</a>

								<div class="navbar-dropdown">
									<?php
										$readsize = "SELECT * FROM 1ET_Size";
										$sizeresult = $conn->query($readsize);
										if(!$sizeresult) {
											echo $conn->error;
										}
										while ($sizerow = $sizeresult->fetch_assoc()) {
											
											$size = $sizerow['Size'];
											$sizeid = $sizerow['ID'];
											echo "<a class='dropdown-item' href='sortby.php?size=$sizeid' class='navbar-item'>
												$size
											</a>
											";
										}
									 ?>
								</div>
							</div>
						</nav>
					</div>
					
					<!--sport category-->
					<div class="column is-two">
						<nav class="navbar" role="navigation" aria-label="dropdown navigation">
							<div class="navbar-item has-dropdown is-hoverable">
								<a class="navbar-link">
									Sport
								</a>

								<div class="navbar-dropdown">
									<?php
										$readsport = "SELECT * FROM 1ET_Sport";
										$sportresult = $conn->query($readsport);
										if(!$sportresult) {
											echo $conn->error;
										}
										while ($sportrow = $sportresult->fetch_assoc()) {
											
											$sport = $sportrow['Sport'];
											$sportid = $sportrow['ID'];
											echo "<a class='dropdown-item' href='sortby.php?sport=$sportid' class='navbar-item'>
												$sport
											</a>
											";
										}
									 ?>
								</div>
							</div>
						</nav>
					</div>
					
					<!--sort by date-->
					<div class="column is-two">
						<nav class="navbar" role="navigation" aria-label="dropdown navigation">
							<div class="navbar-item has-dropdown is-hoverable">
								<a class="navbar-link">
									Date
								</a>

								<div class="navbar-dropdown">
									<?php
										echo "<a class='dropdown-item' href='sortby.php?newestdate' class='navbar-item'>
											Newest
										</a>
										<a class='dropdown-item' href='sortby.php?oldestdate' class='navbar-item'>
											Oldest
										</a>
										";
									?>
								</div>
							</div>
						</nav>
					</div>
					
					<!--search bar-->
					<div class="column is-two">
						<form action='sortby.php' method='GET'> 
							<div class="field has-addons">
								<div class="control">
									<input class="input" type="text" name="itemsearch" placeholder="Search for an item">
								</div>
								<div class="control">
									<a class="button is-info">
										Search
									</a>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</section>
	
	<div class="section">
		<p class="title">Edit your profile</p>
		<form action='process/editprofileprocess.php' method='POST' enctype='multipart/form-data'> 

		<?php
		
		while ($userrow = $result->fetch_assoc()) {
			
			$userid = $userrow['ID'];
			$userem = $userrow['EmailAddress'];
			$userpw = $userrow['Password'];
			$userpn = $userrow['PhoneNumber'];
			$userli = $userrow['LearningInstitute'];
			$usersm = $userrow['SocialMedia'];
			$userimg = $userrow['ProfileImg'];
			
			echo "
			<input type='hidden' value='$userid' name='newid'>
			
			<p>Email address(required)</p>
			<div class='field'>
				<div class='control'>
					<input value='$userem' name='newem'"; ?> required <?php echo ">
				</div>
			</div>
			
			<p>Password (required)</p>
			<div class='field'>
				<div class='control'>			
					<input value='$userpw' name='newpw'"; ?> required <?php echo ">
				</div>
			</div>
			
			<p>Phone number</p>
			<div class='field'>
				<div class='control'>
					<input value='$userpn' name='newpn'>
				</div>
			</div>

			<p>Learning institute</p>
			<div class='field'>
				<div class='control'>
					<input value='$userli' name='newli'>
				</div>
			</div>	
			
			<p>Social media</p>
			<div class='field'>
				<div class='control'>
					<input value='$usersm' name='newsm'>
				</div>
			</div>

			<div class='field is-grouped'>
					<div class='control'>
						<div class='file has-name'>
							<label class='file-label'>
								<input value='$userimg' class='file-input' type='file' name='newimg' id='file'";?> required <?php echo">
							 
								<span class='file-cta'>
									<span class='file-icon'>
										<i class='fas fa-upload'></i>
									</span>
								</span>
								<span class='file-name'>
									<label for='file'><span id='filename'>Upload a profile image</span></label>
								</span>
							</label>
						</div>
					</div>
					
					<div class='control'>
						<input class='button is-primary' type='submit' value='Update'>
					</div>
				</div>
			";	
		}
		?>
		</form>
	</div>
	
	<script>
		// toggles navbar icon
		$(document).ready(function() {

			$(".navbar-burger").click(function() {

				$(".navbar-burger").toggleClass("is-active");
				$(".navbar-menu").toggleClass("is-active");
			});
		});
		
		// selects file to upload
		var file = document.getElementById("file");
		file.onchange = function(){
			if(file.files.length > 0)
			{
			  document.getElementById('filename').innerHTML = file.files[0].name;
			}
		};
	</script>	
  </body>
</html>