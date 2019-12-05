<?php 
  session_start(); 

  if (!isset($_SESSION['username'])) {
<<<<<<< HEAD
    $_SESSION['msg'] = "You must log in first";
    echo $_SESSION['msg'];
    header('location: login.php');
=======
  	$_SESSION['msg'] = "You must log in first";
    echo $_SESSION['msg'];
  	header('location: login.php');
>>>>>>> a5988675aa5fa0c2ccf3a8fbed6e26a8fbc3d810
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
<?php

  require_once 'app/init.php';

  if(isset($_GET['q']))
  {
    function xss_clean($data)
        {
        // Fix &entity\n;
        $data = str_replace(array('&amp;','&lt;','&gt;'), array('&amp;amp;','&amp;lt;','&amp;gt;'), $data);
        $data = preg_replace('/(&#*\w+)[\x00-\x20]+;/u', '$1;', $data);
        $data = preg_replace('/(&#x*[0-9A-F]+);*/iu', '$1;', $data);
        $data = html_entity_decode($data, ENT_COMPAT, 'UTF-8');

        // Remove any attribute starting with "on" or xmlns
        $data = preg_replace('#(<[^>]+?[\x00-\x20"\'])(?:on|xmlns)[^>]*+>#iu', '$1>', $data);

        // Remove javascript: and vbscript: protocols
        $data = preg_replace('#([a-z]*)[\x00-\x20]*=[\x00-\x20]*([`\'"]*)[\x00-\x20]*j[\x00-\x20]*a[\x00-\x20]*v[\x00-\x20]*a[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2nojavascript...', $data);
        $data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*v[\x00-\x20]*b[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2novbscript...', $data);
        $data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*-moz-binding[\x00-\x20]*:#u', '$1=$2nomozbinding...', $data);

        // Only works in IE: <span style="width: expression(alert('Ping!'));"></span>
        $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?expression[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
        $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?behaviour[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
        $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:*[^>]*+>#iu', '$1>', $data);

        // Remove namespaced elements (we do not need them)
        $data = preg_replace('#</*\w+:\w[^>]*+>#i', '', $data);

        do
        {
                // Remove really unwanted tags
                $old_data = $data;
                $data = preg_replace('#</*(?:applet|b(?:ase|gsound|link)|embed|frame(?:set)?|i(?:frame|layer)|l(?:ayer|ink)|meta|object|s(?:cript|tyle)|title|xml)[^>]*+>#i', '', $data);
        }
        while ($old_data !== $data);

        // we are done...
        return $data;
        }

    $xq = xss_clean($_GET['q']);

    $query = $es->search([
        'index' => 'final',
        'type' => '_doc',
        'from' => 0,
        'size' => 1000,
        'body' => [
          'query' =>[
                     'multi_match' => [ 'query' => $xq,
                      'fields' => ['city' ,'name', 'country', 'address','postalCode','province  ']]
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
	$total=$query['hits']['total']['value'];


function highlightWords($text,$word) {
	$text = preg_replace('#'. preg_quote($word) .'#i', '<span style="background-color: #F5130C;">\\0</span>', $text);
	return $text;
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
  <link rel="stylesheet" href="styles.css">
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
  <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
  <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/list.js/1.5.0/list.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>  
  <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
  <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
  <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
  <script type="text/javascript" src="save.js"></script>




</head>
<!-- <script type="text/javascript">

  var myHilitor; // global variable
  window.addEventListener("DOMContentLoaded", function(e) {
    myHilitor = new Hilitor("content");
    myHilitor.apply("<?php echo $xq; ?>");
  }, false);

</script> -->
<script type="text/javascript">
  $(document).ready(function(){
    var options={
      valueNames:['name','category'],
      page:10,
      pagination: true
    }
    var listObj = new List('listId',options);
  });
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
<br>
<br>
<br>
<br>
<br>
<form action="display1.php" method="get" autocomplete="on">
<!-- <div class="" style="text-align: center">
   <div class="" >
      <input type="text" class=""  name="q" placeholder="What are you looking for?">
      <button type="submit" class=""> Go
        <i class=""></i>
     </button>
   </div>
   <a href="advance.php"><b>Advanced_Search</b></a>
   <br>
   <a href="add.php">ADD</a>
   <br>
   <a href="index.php">BACK</a>

</div> -->
<div class="wrap1">
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
   <a href="advance.php"><b>Advanced_Search</b></a>&nbsp;
   &nbsp;
   <a href="add.php"><b>ADD</b></a>&nbsp;&nbsp;
   
</div>
</form>

<br>
<br>
<br>
<br>

 <div class="" style="text-align: center">
    <div class="" style="">
       <h1>Restaurant Search</h1>
    
    <?php  echo "Showing results for : ";echo "<strong>".$xq."</strong>"; echo nl2br("\r\n");?>
    <?php echo "total results : ".$total; echo nl2br("\r\n"); ?>
    
    </div>
  </div>
  
<br>

<br>
 <div class="" style="text-align: center">
    <div class="" >
    <h2> Search Results: </h2>
    </div>
  </div>
  <div id="listId">
    <ul class="list">
      <?php echo $total ?>

      <?php
      for ($i=0; $i < $total; $i++) {
        ?>
        <div class="row" style="text-align: center">
          <div class="container">
            <div class="panel panel-success">
                        <div class=panel-heading style="background-color: #9fe0e4;">
                          <h2 class=panel-title>
                           
                            <a href="<?php echo $results[$i]['_source']['websites']; ?>" target="_blank">
                            <?php $name= !empty($xq)?highlightWords($results[$i]['_source']['name'],$xq):$results[$i]['_source']['name'];
                                echo $name; ?><br>
                          </a>
                        </div>
                            <b>address:</b>                                <?php $address= !empty($xq)?highlightWords($results[$i]['_source']['address'],$xq):$results[$i]['_source']['address'];
                                echo $address; ?><br>
                            <b>Categories:</b>
                                <?php $Categories= !empty($xq)?highlightWords($results[$i]['_source']['primaryCategories'],$xq):$results[$i]['_source']['primaryCategories'];
                                echo $Categories; ?><br>
                            <b>Postalcode:</b>
                                <?php $postalCode= !empty($xq)?highlightWords($results[$i]['_source']['postalCode'],$xq):$results[$i]['_source']['postalCode'];
                                echo $postalCode; ?>
                            <br>
                            <input id="<?php echo $results[$i]['_source']['id']; ?>" method="POST" type="submit" class="btn btn-success save" value="Save">
                          
                    </div>
                  </div>
                </div>
              <?php
            }
               ?>

    </ul>
    <center><ul class="pagination"></ul></center>
  </div>
  

  
  </body>
  </html>

  <!--<div id="listId">
    <ul class="list">

      <?php
      for ($i=0; $i < $total; $i++) {
        ?>
        # code...

        

          <?php $name= !empty($xq)?highlightWords($results[$i]['_source']['name'],$xq):$results[$i]['_source']['name'];
          echo "<li class=snippet>";
          echo $name;

        echo "</li>";
      
      ?>
      <input id="<?php echo $results[$i]['_source']['id']; ?>" method="POST" type="submit" class="btn btn-success save" value="Save">
      <?php
    }
?>

    </ul>
    <ul class="pagination"></ul>
  </div>-->
