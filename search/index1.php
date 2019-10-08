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
  <a href="index1.php" class="active">Country</a>
  <a href="#Venue">Venue</a>
  <a href="#Series">Series</a>
  <a href="profile.php" name="getprofile">Myprofile</a>
 
  

</div>

<br>

<div class="wrap">
  <?php  if (isset($_SESSION['username'])) : ?>
      <p>Welcome <strong><?php echo $_SESSION['username']; ?> </strong></p>   
  <?php endif ?>
   <div class="search">
      <input type="text" class="searchTerm" placeholder="What are you looking for?">
      <button type="submit" class="searchButton"> Go
        <i class="fa fa-search"></i>
     </button>
   </div>
</div>


<div class="footer">
  <p> <a href="logout.php?logout='1'" style="color: black;">logout</a> </p>
</div>
		
</body>
</html>