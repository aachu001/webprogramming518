<?php 
  session_start(); 

  if (!isset($_SESSION['username'])) {
  	$_SESSION['msg'] = "You must log in first";
    echo $_SESSION['msg'];
  	header('location: login.php');
  }
 
?>
<!DOCTYPE html>
<html>
<head>

  <meta charset='utf-8'>
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="styles.css">

	<title>Home</title>
	
</head>

<body>


  
<div class="topnav">
  <a href="index1.php">Country</a>
  <a href="#collections">MyCollections</a>
  <a href="profile.php" class="active">Myprofile</a>
  <div class="search-container">
    <form action="/action_page.php">
      <input type="text" placeholder="Search.."  name="search">
      <button type="submit" class="searchButton">
        <i class="fa fa-search"></i>
     </button>
    </form>
  </div> 
</div>

<br>

<div class="content">
  	<!-- notification message -->
  	<?php if (isset($_SESSION['success'])) : ?>
      <div class="error success" >
      	<h3>
          <?php 
          	echo $_SESSION['success']; 
          	unset($_SESSION['success']);
          ?>
      	</h3>
      </div>
  	<?php endif ?>

    <!-- logged in user information -->
    <?php  if (isset($_SESSION['username'])) : ?>
    	<p>Welcome <strong><?php echo $_SESSION['username']; ?></strong></p>
    	
    <?php endif ?>
</div>

<div class="footer">
  <p> <a href="logout.php?logout='1'" style="color: black;">logout</a> </p>
</div>
		
</body>
</html>