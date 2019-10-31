<?php

  require_once 'app/init.php';

  if(isset($_GET['name']))
  {
    $name = $_GET['name'];
    $city = $_GET['city'];
    
    $query = $es->search([
        'index' => 'final',
        'type' => '_doc',
        'body' => [
          'query' =>[
            'bool' => [
            'must' => [
              
              ['match' => ['city' => $city]],
              ['match' => ['name' => $name]]

              
            ]
          ]
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
<html lang="en">
<head>

  <meta charset="utf-8">
  <title>Search | Document Search</title>
  <meta name="description" content="search-results">
  <meta name="author" content="Ruan Bekker">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link href="//fonts.googleapis.com/css?family=Pattaya|Slabo+27px|Raleway:400,300,600" rel="stylesheet" type="text/css">
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link rel="icon" type="image/png" href="images/favicon.png">

  <script src="js/bootstrap.min.js"></script>
  <script src="js/jquery.min.js"></script>

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

<ul class="nav nav-tabs">
  <li role="presentation"><a href="index.php">Home</a></li>
  <li role="presentation"><a href="add.php">Add Bookmark</a></li>
  <li role="presentation"><a href="about.php">About</a></li>
</ul>

<br>
<div class="row vertical-center-row">
    <div class="col-lg-4 col-lg-offset-4">
        <div class="input-group">
            <h1>Document Search</h1><p>
            <h3>powered by php and elasticsearch</h3>
        </div>
    </div>
</div>

<br>
<br>
<form action="results.php" method="get" autocomplete="on">
<div class="row">
    <div class="col-lg-4 col-lg-offset-4">
        <div class="input-group">
          <input type="text" name="q" placeholder="Search..." class="form-control" /> 
            <span class="input-group-btn"> 
                <button type="submit" class="btn btn-primary">Search</button>
                <a class="btn btn-danger" href="index.php">Back</a> 
            </span>
        </div>
    </div>
</div>
</form>
<br>

<br>
 <div class="container">
    <div class="row" style="text-align: center">
    <h2> Search Results: </h2>
    </div>
  </div>


        <?php
        if(isset($results)) {
            foreach($results as $r) {
            ?>

                <div class="row" style="text-align: center">
        <div class="container">
          <div class="panel panel-success">
                      <div class=panel-heading>
                        <h2 class=panel-title>
                          <a href="index.php" target="_blank"><p><br> 
                            <?php echo $r['_source']['city']; ?>
                          </a>
                          
                      </div>
                        <br><br>
                          <b>Content:</b><p> 
                              <?php echo '<pre>', print_r($r['_source']['city']) , '</pre>' ;
                              echo  $r['_source']['city']; 
                              ?><p></p><br>
                      <div class="">
                          <b>DocId:</b>
                            <center>
                                <?php echo $r['_id']; ?>
                            </center>
                          <br>
                    </div> 
                  </div>
                </div>
            <?php
            }
        }
        ?>
</body>
</html>