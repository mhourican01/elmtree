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
  
	$read = "SELECT * FROM 1ET_Items 
	INNER JOIN 1ET_Gender
	ON 1ET_Items.gender_id=1ET_Gender.ID
	INNER JOIN 1ET_Size 
	ON 1ET_Items.Size=1ET_Size.ID 
	INNER JOIN 1ET_Sport 
	ON 1ET_Items.Sport=1ET_Sport.ID 
	WHERE 1ET_Items.item_id ='$row';";
  
	$result = $conn->query($read);
	
	if(!$result) {
		$conn->error;
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Elmtree | Connecting Students</title>
	
		<link rel="stylesheet" type ="text/css" href="../styles/gui.css">
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
	
	<div class="column is-one-third">
	
		<form action='process/edititemprocess.php' method='POST' enctype='multipart/form-data'> 

			<?php
		
				while($irow = $result->fetch_assoc()) {
					$iid = $irow['item_id'];
					$ititle = $irow['Name'];
					$iprice = $irow['Price'];
					$iblurb = $irow['Blurb'];
				
					echo "
					<p class='title'>Edit your advertisement</p>
					<input type='hidden' value='$iid' name='newid'>
				
					<p>Title (required)</p>
					<div class='field'>
						<div class='control'>
							<input value='$ititle' name='newtitle'";?> required <?php echo ">
						</div>
					</div>
					
					<p>Price (required)</p>
					<div class='field'>
						<div class='control'>
							<input value='$iprice' name='newprice'";?> required <?php echo ">
						</div>
					</div>
					";
				}
			?>
					
			<p>Gender </p>
			<div class='select'>
				<select name='newgender'>
					<?php
						$selectgender = 'SELECT * FROM 1ET_Gender';
						$genderresult = $conn->query($selectgender);
						if(!$genderresult) {
							echo $conn->error;
						}
				
						while($genderrow = $genderresult->fetch_assoc()) {
							$gender = $genderrow['Gender'];
							$genderid = $genderrow['ID'];
							echo "
							<option value='$genderid'>$gender</option>
							";
						}
					?>	
				</select>
			</div>

			<p>Size</p>
			<div class='select'>
				<select name='newsize'>
				<?php
				
					$selectsize = "SELECT * FROM 1ET_Size";
					$sizeresult = $conn->query($selectsize);
					if(!$sizeresult) {
						echo $conn->error;
					}
					
					while($sizerow = $sizeresult->fetch_assoc()) {
						$size = $sizerow['Size'];
						$sizeid = $sizerow['ID'];
						echo "
						<option value='$sizeid'>$size</option>
						";
					}	
				?>
				</select>
			</div>
				
			<p>Sport</p>
			<div class='select'>
				<select name='newsport'>
				<?php
				
					$selectsport = "SELECT * FROM 1ET_Sport";
					$sportresult = $conn->query($selectsport);
						
					if(!$sportresult) {
						echo $conn->error;
					}
					
					while($sportrow = $sportresult->fetch_assoc()) {
						$sport = $sportrow['Sport'];
						$sportid = $sportrow['ID'];
						echo "
						<option value='$sportid'>$sport</option>
						";
					}	
				?>
				</select>
			</div>
				
			<?php
			echo "
			<p>Item description: </p>
			<div class='field'>
				<div class='control'>
					<input value='$iblurb' name='newblurb'>
				</div>
			</div>
			";
			?>
			
			<label class="checkbox">
				<input type="checkbox" name="hidenew" value="1">
				Hide from non-registered users
			</label>
			
			<?php
			echo "
				<div class='field is-grouped'>
					<div class='control'>
						<div class='file has-name'>
							<label class='file-label'>
								<input class='file-input' type='file' name='newimg[]' multiple id='file'";?> required <?php echo">
							 
								<span class='file-cta'>
									<span class='file-icon'>
										<i class='fas fa-upload'></i>
									</span>
								</span>
								<span class='file-name'>
									<label for='file'><span id='filename'>Upload images of your item</span></label>
								</span>
							</label>
						</div>
					</div>
					
					<div class='control'>
						<input class='button is-primary' type='submit' value='Update'>
					</div>
				</div>
				";
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