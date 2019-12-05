<?php 
  session_start(); 

  if (!isset($_SESSION['username'])) {
  	$_SESSION['msg'] = "You must log in first";
    echo $_SESSION['msg'];
  	header('location: login.php');
  }
?>
<?php 
if (!isset($_SESSION['username'])) {
    $_SESSION['msg'] = "You must log in first";
    echo $_SESSION['msg'];
    header('location: login.php');
  }

elseif (!$_SESSION['verified']){


header('location: verify.php');

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

<body>


  
<div class="topnav">
  <a href="index1.php">Home</a>
  <a href="#City">City</a>
  <a href="#Venue">Categories</a>
  <a href="#Series">Name</a>
  <a href="profile.php">Myprofile</a>
  
</div>

<br>


<form action="display1.php" method="get" autocomplete="on">
<div class="wrap">
  <?php  if (isset($_SESSION['username'])) : ?>
      <p>Welcome <strong><?php echo $_SESSION['username']; ?> </strong></p>   
  <?php endif ?>
   <div class="search">
      <input type="text" class="searchTerm"  id="speechText" name="q" placeholder="What are you looking for?">
      <button type="submit" class="searchButton"> Go
        <i class="fa fa-search"></i>
     </button> &nbsp;
     <input type='button' id='start' value='Start' onclick='startRecording();'>
   </div>
   <a href="advance.php"><b>Advanced_Search</b></a>
   <br>
   <br>
   <a href="add.php">ADD</a>

</div>
</form>


<div class="footer">
  <p> <a href="logout.php?logout='1'" style="color: black;">logout</a> </p>
</div>
		
</body>
</html>