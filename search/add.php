<?php

require_once 'app/init.php';

if (!empty($_POST)) {
  if(isset($_POST['id'], $_POST['address'], $_POST['city'])) {

    //$rowid = $_POST['rowid'];
    $id = $_POST['id'];
    $address = $_POST['address'];
    $categories = explode(',', $_POST['categories']);
    $primaryCategories = explode(',', $_POST['primaryCategories']);
    $city = $_POST['city'];
    $country = $_POST['country'];
    $keys = $_POST['keys'];
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];
    $name = $_POST['name'];
    $postalCode = $_POST['postalCode'];
    $province = $_POST['province'];
    $sourceURLs = $_POST['sourceURLs'];
    $websites = $_POST['websites'];
    
    

    $indexed = $es->index([
      'index' => 'final',
      'type' => '_doc',
      //'id' => $rowid,
      'body' => [
        'id' => $id,
        'address' => $address,
        'categories' => $categories,
        'primaryCategories' => $primaryCategories,
        'city' => $city,
        'country' => $country,
        'keys' => $keys,
        'latitude' => $latitude,
        'longitude' => $longitude,
        'name' => $name,
        'postalCode' => $postalCode,
        'province' => $province,
        'sourceURLs' => $sourceURLs,
        'websites' => $websites
        ]
      ]);

      if($indexed) {
        print_r($indexed);
      }
  }
}

?>
<!DOCTYPE html>
<html>
<head>
  <title>add</title>
  <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
  <div class="header">
  	<h2>ADD</h2>
  </div>
	 
  <form method="post" action="add.php" autocomplete="off">

  	
  	<div class="input-group">
  		<label>id</label>
  		<input type="text" name="id" required>
  	</div>
  	<div class="input-group">
  		<label>address</label>
  		<input type="text" name="address" required>
  	</div>
    <div class="input-group">
      <label>categories</label>
      <input type="text" name="categories" required>
    </div>
    <div class="input-group">
      <label>primaryCategories</label>
      <input type="text" name="primaryCategories" required>
    </div>
    <div class="input-group">
      <label>city</label>
      <input type="text" name="city" required>
    </div>
    <div class="input-group">
      <label>country</label>
      <input type="text" name="country" required>
    </div>
    <div class="input-group">
      <label>keys</label>
      <input type="text" name="keys" required>
    </div>
    <div class="input-group">
      <label>latitude</label>
      <input type="number" name="latitude" required>
    </div>
    <div class="input-group">
      <label>longitude</label>
      <input type="number" name="longitude" required>
    </div>
    <div class="input-group">
      <label>name</label>
      <input type="text" name="name" required>
    </div>
    <div class="input-group">
      <label>postalCode</label>
      <input type="number" name="postalCode" required>
    </div><div class="input-group">
      <label>province</label>
      <input type="text" name="province" required>
    </div>
    <div class="input-group">
      <label>sourceURLs</label>
      <input type="text" name="sourceURLs" required>
    </div>
    <div class="input-group">
      <label>websites</label>
      <input type="text" name="websites" required>
    </div>

  	<div class="input-group">
  		<button type="submit" class="btn" name="" value="Add">Add</button>
      <button type="" class="btn"><a href="index.php">Cancel</a></button>
  	</div>
  </form>
</body>
</html>