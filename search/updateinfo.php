
<?php include('server.php') ?>

<html>

<head>
<title>Change Password</title>
<link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body>

	<div class="header">
  	<h2>Update Information</h2>
  </div>
<form method="post" action="updateinfo.php">
  	<?php include('errors.php'); ?>
  	<div class="input-group">
  		<label>Username</label>
  		<input type="text" name="username" >
  	</div>
  	<div class="input-group">
  		<label>Current password</label>
  		<input type="text" name="password" >
  	</div>
  	<div class="input-group">
  		<label>Firstname</label>
  		<input type="text" name="fn" >
  	</div>
  	<div class="input-group">
  		<label>Country</label>
  		<input type="password" name="country">
  	</div>
  	<div class="input-group">
  	  <button type="submit" class="btn" name="updateinfo_user">Update</button>
      <button type="" class="btn">  <p> <a href="index.php?logout='1'" style="color: black;">logout</a> </p>
</button>
  	</div>
  </form>
</body>
</html>	