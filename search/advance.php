<?php include('server.php') ?>
<!DOCTYPE html>
<html>
<head>
  <title>Filter_Search</title>
  <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
  <div class="header">
  	<h2>Advance_Search</h2>
  </div>
	
  <form method="get" action="adv.php">
  	<?php include('errors.php'); ?>
    <div class="input-group">
      <label>Name</label>
      <input type="text" name="name" required>
    </div>
  	<div class="input-group">
  	  <label>City </label>
  	  <input type="text" name="city" required>
  	</div>
    <div class="input-group">
      <label>Province </label>
      <input type="text" name="province" required>
    </div>
    <div class="input-group">
      <label>Country</label>
      <input type="text" name="country" required>
    </div>
  	<div class="input-group">
  	  <button type="submit" class="btn" name="searchdocuments">Search</button>
      <button type="" class="btn"><a href="index.php">Cancel</a></button>
  	</div>
  </form>
</body>
</html>