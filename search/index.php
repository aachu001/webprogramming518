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
<style>
body, html {
  height: 100%;
  margin: 0;
}

.bg {
  /* The image used */
  background-image: url("https://unsplash.com/photos/wMzx2nBdeng");

  /* Full height */
  height: 100%; 

  /* Center and scale the image nicely */
  background-position: center;
  background-repeat: no-repeat;
  background-size: cover;
}
</style>
<script>
var recognition = new webkitSpeechRecognition();
recognition.onresult = function(event) { 
  var saidText = "";
  for (var i = event.resultIndex; i < event.results.length; i++) {
    if (event.results[i].isFinal) {
      saidText = event.results[i][0].transcript;
    } else {
      saidText += event.results[i][0].transcript;
    }
  }
  // Update Textbox value
  document.getElementById('speechText').value = saidText;
 
  // Search Posts
  searchPosts(saidText);
}
function startRecording(){
  recognition.start();
}
</script>

<body class='bg'>


<div class="topnav">
  <a href="index.php">Home</a>
  <a href="#City">City</a>
  <a href="#Venue">Categories</a>
  <a href="#Series">Name</a>
  <a href="rest.html">restaurant</a>
  <div class="search-container">
    <a href="register.php">SignUP</a>
    <a href="login.php">Login</a>
  </div>
  
</div>
<form action="display.php" method="get" autocomplete="on">
  <div class='wrap'>
  <!-- Search box-->
  <div class="search">
  <input type='text' class='searchTerm' id='speechText' name='q'> 
  <button type="submit" class="searchButton"> Go
        <i class="fa fa-search"></i>
     </button> &nbsp; 
     
  <input type='button' id='start' value='Start' onclick='startRecording();'>


</div>
<a href="advance.php"><b>Advanced_Search</b></a>
   <br>
   <br>
    
</div>
<!-- Search Result -->
<div class="container"></div>
</form>

</body>
</html>
<!-- <div class="wrap">
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
    -->