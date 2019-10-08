
<?php include('server.php') ?>

<html>

<head>
<title>Change Password</title>
<link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body>

	<div class="header">
  	<h2>Change password</h2>
  </div>
<form method="post" action="changepassword.php">
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
  		<label>new password</label>
  		<input type="text" name="password_1" >
  	</div>
  	<div class="input-group">
  		<label>Cofirm Password</label>
  		<input type="password" name="password_2">
  	</div>
  	<div class="input-group">
  	  <button type="submit" class="btn" name="changepass_user">Update</button>
      <button type="" class="btn">  <p> <a href="index.php?logout='1'" style="color: black;">logout</a> </p>
</button>
  	</div>
  </form>
</body>
</html>	