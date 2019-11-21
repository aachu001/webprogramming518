<?php include('server.php') ?>
<!DOCTYPE html>
<html>
<head>
  <title>Login</title>
  <script src="https://www.google.com/recaptcha/api.js" async defer></script>
  <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
  <div class="header">
  	<h2>Login</h2>
  </div>
	 
  <form method="post" action="login.php">
  	<?php include('errors.php'); ?>
  	<div class="input-group">
  		<label>Username</label>
  		<input type="text" name="username" >
  	</div>
  	<div class="input-group">
  		<label>Password</label>
  		<input type="password" name="password">
  	</div>
    <div class="g-recaptcha" data-sitekey="6LeiD8EUAAAAAALaiOjrvBCP1DhoEESHH1OoZcxF"></div>
  	<div class="input-group">
  		<button type="submit" class="btn" name="login_user">Login</button>
      <button type="" class="btn"><a href="forgotpassword.php">ForgotPasssword</a></button>
      <button type="" class="btn"><a href="index.php">Cancel</a></button>
  	</div>
    
  	<p>
  		Not yet a member? <a href="register.php">Sign up</a>
  	</p>
  </form>
</body>
</html>