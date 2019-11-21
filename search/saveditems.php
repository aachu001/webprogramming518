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

	<title>SavedItems</title>
	
</head>

<body>

	<div class="topnav">
		<a href="index1.php">Home</a>
  		<a href="profile.php" class="active">Myprofile</a>
	</div>	

	<br>

	<div class="header">
  	<h2>MyItems</h2>
  	
  </div>
	 
  <form method="get" action="">
  	
  	<div class="input-group">
  		
  	<?php  if (isset($_SESSION['username'])) : ?>
      <p>Username: <strong>Hello <?php echo $_SESSION['username']; ?> below are items you saved</strong></p>
    <?php endif ?>
  	</div>
  	
  	<?php
    $solutions = array();
  		$db = mysqli_connect('localhost', 'admin', 'monarchs', 'm2');
  		$query = "SELECT * from saveitems WHERE user ='abhi1212'";
  		$result = mysqli_query( $db, $query );
  		$row = mysqli_fetch_array($result, MYSQLI_ASSOC);

//       while($r = mysqli_fetch_array($result,MYSQLI_ASSOC)) {
//   $solutions[] = $r['name'];
// }

      
  		echo nl2br ("Name :{$row['name']} \n "); 
      echo nl2br("Categories :{$row['categories']} \n ");
      echo "Address :{$row['address']} ";
     
  	?>

  	
  	
  	
  	
  </form>




<div class="footer">
  <p> <a href="logout.php?logout='1'" style="color: black;">logout</a> </p>
</div>

</body>
</html>