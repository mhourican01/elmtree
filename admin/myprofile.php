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

	if(isset($_GET['userid'])){
		$getid = $_GET['userid'];
  
		$read = "SELECT * FROM 1ET_Users
		WHERE id ='$getid';";
  
		$result = $conn->query($read);
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
		<?php
			while($row = $result->fetch_assoc()) {
				$userem = $row['EmailAddress'];
				$userpn = $row['PhoneNumber'];
				$userli = $row['LearningInstitute'];
				$usersm = $row['SocialMedia'];
				$image = $row['ProfileImg'];
				$rowid = $row['ID'];
				echo "<div class='columns'>
					<div class='column is-one-third is-pulled-left'>
						<img src='../profileimg/$image'/>
					</div>
					<div class='column is-two-thirds is-pulled-right'>
						<p class='title'>My profile</p>
						<br>
						<p class='subtitle'><strong>Email address: </strong>$userem</p>
						<p class='subtitle'><strong>Telephone number: </strong> $userpn</p>
						<p class='subtitle'><strong>Learning institute: </strong> $userli</p>
						<p class='subtitle'><strong>Social media: </strong> $usersm</p>
						";
						if($userem==$user) {
							echo "
							<a href='editprofile.php?editid=$rowid' class='button is-primary'>Edit profile</a>
							";
						}
						echo "
					</div>
				</div>			
				";	
			}
		?>
	</div>
	
	<script>
		// toggles navbar icon
		$(document).ready(function() {

			$(".navbar-burger").click(function() {

				$(".navbar-burger").toggleClass("is-active");
				$(".navbar-menu").toggleClass("is-active");
			});
		});
	</script>	
  </body>
</html>