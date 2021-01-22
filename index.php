<?php
	session_start();
		
	session_unset();
	
	include("conn.php");
	
	// selects items for thumbnails
	$readitems = "SELECT * FROM 1ET_Items
	WHERE Visibility='0';
	;";
	
	$itemsresult = $conn->query($readitems);
	
	if (!$itemsresult) {
		$conn->error;
	}
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Elmtree | Connecting Students</title>
	
	<link rel="stylesheet" href="styles/gui.css"/>
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
							<a class="navbar-item is-active" href="register.php">
								Register
							</a>
							<a class="navbar-item" href="login.php">
								Login
							</a>
						</div>
					</div>
				</div>
			</nav>
		</div>
	  
		<div class="hero-body">	
			<div class="container has-text-centered">
				<a href="index.php">
					<img src="webimg/icon.png" class="ctrimg">
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
	
		<!--generates item thumbnails-->
		<section>
			<div class="tile is-12 is-ancestor ptile">
				<?php
					while($itemrow = $itemsresult->fetch_assoc()) {
						$itemid = $itemrow['item_id'];
						$itemname = $itemrow['Name'];
						$itemprice = $itemrow['Price'];
								
						// selects item image for thumbnails
						$readimg = "SELECT * FROM 1ET_Gallery
						WHERE item_id = '$itemid' LIMIT 1";
								
						$imgresult = $conn->query($readimg);
								
						if(!$imgresult) {
							echo $conn->error;
						}
								
						echo "
							<a href='shoe.php?itemid=$itemid'>
								<div class='tile is-child box ctile'>
									<p class='title'>$itemname</p>
									<p class='subtitle'>£$itemprice</p>
									";
								
									while($imgrow=$imgresult->fetch_assoc()) {
										$imgpath = $imgrow['path']; 
										echo "
										<figure class='image is-4by3'>
											<img src='itemimg/$imgpath'/>
										</figure>
										";			
									}
								echo "</div>
							</a>
						";		
					}
				?>		
			</div>
		</section>
	
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