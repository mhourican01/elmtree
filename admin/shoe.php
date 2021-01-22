<?php
	session_start();
	
	if(!isset($_SESSION[''])) {
		header('Location: ../index.php');
	}
	
	$user = $_SESSION[''];
	$myid = $_SESSION[''];

	include("../conn.php");
	
	// selects user data for navbar
	$readuser = "SELECT * FROM 1ET_Users
	WHERE EmailAddress='$user';
	";
	
	$userresult = $conn->query($readuser);
	
	if (!$userresult) {
		$conn->error;
	}
  
  if(isset($_GET['itemid'])){
	$itemid = $_GET['itemid'];
  
	$read = "SELECT * FROM 1ET_Items 
	INNER JOIN 1ET_Gender 
	ON 1ET_Items.gender_id=1ET_Gender.ID 
	INNER JOIN 1ET_Size
	ON 1ET_Items.Size=1ET_Size.ID
	INNER JOIN 1ET_Sport 
	ON 1ET_Items.Sport=1ET_Sport.ID
	WHERE 1ET_Items.item_id ='$itemid';";
	
	$readimg = "SELECT * FROM 1ET_Gallery
	WHERE item_id = '$itemid'";
  
	$result = $conn->query($read);
	
	if(!$result) {
		echo $conn->error;
	}
	
	$imgresult = $conn->query($readimg);
	
	if(!$imgresult) {
		echo $conn->error;
	}
  }
	
	$readbuyer = "SELECT * FROM 1ET_Exchanges;";
	
	$buyerresult = $conn->query($readbuyer);
	
	if(!$buyerresult) {
		$conn->error;
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
	<div class='columns'>
		<?php
			while($row = $result->fetch_assoc()) {
				$itemid = $row['item_id'];
				$name = $row['Name'];
				$price = $row['Price'];
				$gender = $row['Gender'];
				$size = $row['Size'];
				$sport = $row['Sport'];
				$blurb = $row['Blurb'];
				$seller = $row['Seller'];
				
				echo "
					<div class='column is-two-thirds is-pulled-left'>
						<p class='title'>$name</p>
						<p class='subtitle'>£$price</p>
						<p class='subtitle'><strong>Gender: </strong>$gender</p>
						<p class='subtitle'><strong>Size: </strong>$size</p>
						<p class='subtitle'><strong>Sport: </strong>$sport</p>
						<p class='subtitle'><strong>Item description: </strong> $blurb</p>
						";
						
						while($buyrow = $buyerresult->fetch_assoc()){
							$exid = $buyrow['Exchange_ID'];
							$exitem = $buyrow['Item'];
							$selectbuyer = $buyrow['SelectedBuyer'];
							$buyer = $buyrow['ConfirmedBuyer'];
							
							if($exitem==$itemid) {
								
								if($selectbuyer==$buyer) {
									echo "
										<p class='title'>This item has been purchased.</p>
									";
								} elseif ($selectbuyer==$myid) {
									echo "
									<p>The seller of this item has selected you as its buyer.</p>
									<form action='process/buyprocess.php?confitem=$exitem' method='POST'>
										<div class='field'>
											<div class='control'>
												<input class='input' type='text' name='confirmbuyer' placeholder='Enter your email address to confirm'>
										  </div>
										</div>
										<input class='button is-primary' type='submit' value='Confirm purchase'>
									</form>
									";
								}
							}
						}
						
						echo "
						<a href='profile.php?itemid=$itemid' class='button is-primary'>Visit seller's profile</a>
						";
						
						if($seller==$userid) {
							echo "
							
							<a href='edititem.php?editid=$itemid' class='button is-primary'>Edit ad</a>
							<a href='process/deleteprocess.php?deleteid=$itemid' class='button is-primary'>Remove ad</a>
							";
							
							echo "
							<form action='process/buyprocess.php?buyitem=$itemid' method='POST'>
								<input type='hidden' value='$userid' name='seller'>
									<div class='field'>
										<div class='control'>
											<input class='input' type='text' name='buyer' placeholder='Enter email address of buyer'"; ?> required <?php echo ">
										</div>
									</div>
								<input class='button is-primary' type='submit' value='Update buyer'>
							</form>
							
							";
						}
						echo "
					</div>
					
					<div class='column is-one-third is-pulled-right'>
						<div class='tile is-12 is-ancestor is-vertical ptile'>
						";
						while ($imgrow = $imgresult->fetch_assoc()) {
							$imgpath = $imgrow['path'];
						
							echo "
								<div class='tile is-child ctile'>
									<img src='../itemimg/$imgpath'/>
								</div>
							";
						}
						echo "
						</div>
					</div>
				";	
			}
		?>
		</div>
	</div>
	
	<script>
		$(document).ready(function() {

			// Check for click events on the navbar burger icon
			$(".navbar-burger").click(function() {

				// Toggle the "is-active" class on both the "navbar-burger" and the "navbar-menu"
				$(".navbar-burger").toggleClass("is-active");
				$(".navbar-menu").toggleClass("is-active");
			});
		});
	</script>	
  </body>
</html>