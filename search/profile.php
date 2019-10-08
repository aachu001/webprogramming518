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
  <link rel="stylesheet" href="style.css">

	<title>My Profile</title>
	
</head>

<body>

	<div class="topnav">
		<a href="index1.php">Home</a>
  		<a href="profile.php" class="active">Myprofile</a>
	</div>	

	<br>

	<div class="header">
  	<h2>Myprofile</h2>
  	
  </div>
	 
  <form method="get" action="">
  	
  	<div class="input-group">
  		
  	<?php  if (isset($_SESSION['username'])) : ?>
      <p>Username: <strong><?php echo $_SESSION['username']; ?></strong></p>
    <?php endif ?>
  	</div>
  	
  	<?php
  		$db = mysqli_connect('localhost', 'admin', 'monarchs', 'se');
  		$query = "SELECT *from users WHERE username='" . $_SESSION["username"] . "'";
  		$result = mysqli_query( $db, $query );
  		$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
      
  		echo nl2br ("Email :{$row['email']} \n "); 
      echo nl2br("Firstname :{$row['firstname']} \n ");
      echo "Country :{$row['country']} ";
     
  	?>

  	
  	
  	<div class="input-group">
  		
  	<a href="changepassword.php">ChangePassword</a>
    <a href="updateinfo.php">UpdateInformartion</a>
  	
  	</div>
  	
  </form>




<div class="footer">
  <p> <a href="logout.php?logout='1'" style="color: black;">logout</a> </p>
</div>

</body>
</html>