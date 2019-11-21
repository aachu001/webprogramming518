<?php 
               session_start();
               $db = mysqli_connect('localhost', 'admin', 'monarchs', 'm2');
              

                $userLoginQuery = "SELECT * FROM `saveitems` WHERE `user`= 'abhi1212' ";

               $result = $db->query($userLoginQuery);   
              if ($result->num_rows > 0) {
                
                while($row = $result->fetch_assoc()){
                    
                    
                  $title = $row['name'];
               ?> 
<!DOCTYPE html>
<html lang="en">
<head>

  <meta charset="utf-8">
  <title>Saved Restaurants</title>
  <meta name="description" content="search-results">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script src="https://www.google.com/recaptcha/api.js" async defer></script>

  <link href="//fonts.googleapis.com/css?family=Pattaya|Slabo+27px|Raleway:400,300,600" rel="stylesheet" type="text/css">
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link rel="icon" type="image/png" href="images/favicon.png">

  <script src="js/bootstrap.min.js"></script>
  <script src="js/jquery.min.js"></script>
  
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
      <link rel="stylesheet" href="styles.css">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
      <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
      <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
      <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
      <link href="styles/css/bootstrap.css" rel="stylesheet" />
      <link href="styles/css/index.css" rel="stylesheet" />
      <link href="styles/css/login-register.css" rel="stylesheet" />
      <link rel="stylesheet" href="http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
      <link rel="stylesheet" href="/styles/style.css">
      <script src="styles/js/jquery-1.10.2.js" type="text/javascript"></script>
      <script src="styles/js/bootstrap.js" type="text/javascript"></script>
      <script src="styles/js/login-register.js" type="text/javascript"></script>
      <script src="styles/js/result.js" type="text/javascript"></script>
      <script src="styles/js/pagination.js" type="text/javascript"></script>
      <script src="styles/js/hilitor.js" type="text/javascript"></script>


  <style>
      h1 {
        font-family: 'Pattaya', sans-serif;
        font-size: 59px;
        position: relative;
        right: -10px;
      }

      h3 {
        font-family: 'Pattaya', sans-serif;
        font-size: 20px;
        position: relative;
        right: -90px;
      }

      h4 {
        font-family: 'Slabo', sans-serif;
        font-size: 30px;
      }
  </style>


</head>
<body>
  

<div class="row" style="text-align: center">
        <div class="">
          <div class="">
                      <div class="" style="background-color : aliceblue;">  
                       <p><a href="<?php echo $row['websites'] ?>"><br>
                            <?php echo $title;?></a>
                      </p></div>
                        <br><br>
                              <b>categories</b><p> 
                              <?php echo $row['categories'];?></p><p></p><br>
                              <b>Address</b><p> 
                              <?php echo $row['address'];?></p><p></p><br>
                              <b>Time</b><p> 
                              <?php echo $row['time_stamp'];?></p><p></p><br>
                            <?php }}?>
                <a class="btn btn-lg btn-primary btn-block" href="index1.php">Back</a>
            </div>
        </div>
    </div>
</body>