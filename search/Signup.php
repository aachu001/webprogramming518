 <?php include('server.php') ?>
 <!DOCTYPE html>
 <html>
 <head>
 	<title>
 		Registration
 	</title>
 </head>
 <body>
 	<div class="signup">
 		<div class="signup1">
 			<h2>Sign-UP</h2>
 			
 		</div>
 		<form action="signup.php" method="post">
 			 <?php include('errors.php')  ?>
 			
 			<div>

 				<label for="username">Username:-</label>
 				<input type="text" name="username" required>

 			</div>
  			<div>
 				
 				<label for="email">Email:-</label>
 				<input type="email" name="email" required>

 			</div>
  			<div>
 				
 				<label for="password">Password:-</label>
 				<input type="password" name="password_1" required>

 			</div>
 			<div>
 				
 				<label for="password">Confirm Password:-</label>
 				<input type="password" name="password_2" required>

 			</div>
 			<button type="submit" name="user_signup">Submit</button>
 			<p>Registered user<a href="login.php"><b>login</b></a></p>



 		</form>
 		
 	</div>
 </body>
 </html>
