<?php

  require_once 'app/init.php';

  if(isset($_GET['q']))
  {
    $q = $_GET['q'];

    $query = $es->search([
        'index' => 'final',
        'type' => '_doc',
        'body' => [
          'query' =>[
            
                'match' => ['city' => $q ]
              ]
            ]  
    ]);

    //echo '<pre>', print_r($query) , '</pre>' ;
    //die();

    if($query['hits']['total'] >=1)
    {
      $results = $query['hits']['hits'];
    }
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
  <a href="index.php">Home</a>
  <a href="#City">City</a>
  <a href="#Venue">Categories</a>
  <a href="#Series">Name</a>
  <div class="search-container">
    <a href="register.php">SignUP</a>
    <a href="login.php">Login</a>
  </div>
  
</div>
<form action="display.php" method="get" autocomplete="on">
<div class="wrap">
   <div class="search">
      <input type="text" class="searchTerm"  name="q" oninput='onclick()' placeholder="What are you looking for?">
      <button type="submit" class="searchButton"> Go
        <i class="fa fa-search"></i>
     </button>
      <script type="">
        function onclick(){
          var safe = filterXSS($("#q").val());
          $("#q1").val(safe).trim();
        }
      </script>
   </div>
   <a href="advance.php"><b>Advance_Search</b></a>
   <br>
   <br>
   <!-- <a href="add.php">ADD</a> -->

</div>
</form>



</body>


  
</html>