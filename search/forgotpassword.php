<?php include('server.php') ?>
<!DOCTYPE html>
<html>
<head>
	<title>forgot Password</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	<div class="header">
  	<h2>Resetpassword</h2>
  </div>

	<form method="post" action="forgotpassword.php">
  	<?php include('errors.php'); ?>
  	<div class="input-group">
  	  <label>Username</label>
  	  <input type="text" name="username" value="<?php echo $username; ?>">
  	</div>
  	<div class="input-group">
  	  <label>Email</label>
  	  <input type="email" name="email" value="<?php echo $email; ?>">
  	</div>
  	<div class="input-group">
  	  <label>Change Password</label>
  	  <input type="password" name="password_1">
  	</div>
  	<div class="input-group">
  	  <label>Confirm Password</label>
  	  <input type="password" name="password_2">
  	</div>
  	<div class="input-group">
  	  <button type="submit" class="btn" name="resetpass_user">Reset Password</button>
      <button type="" class="btn"><a href="index.php">Cancel</a></button>
  	</div>
  	<p>
  		Not a member? <a href="register.php">Sign up</a>
  	</p>
  	<p>
  		Got the password <a href="login.php">Login</a>
  	</p>
  </form>

</body>
</html>