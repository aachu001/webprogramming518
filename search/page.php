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
  $v = intval(($total/10));
  if($v==0)
  {
    $noofpages = $v;
  }
  else
  {
    $noofpages = $v + 1;
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
  <script type="text/javascript" src="hilitor.js"></script>
  <script type="text/javascript" src="save.js"></script>
  <script type="text/javascript" src="pagination.js"></script>


  

</head>
<script type="text/javascript">

  var myHilitor; // global variable
  window.addEventListener("DOMContentLoaded", function(e) {
    myHilitor = new Hilitor("content");
    myHilitor.apply("<?php echo $xq; ?>");
  }, false);

</script>
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

  <a href="index.php">Country</a>
  <a href="#Venue">Venue</a>
  <a href="#Series">Series</a>
  <div class="search-container">
    <a href="register.php">SignUP</a>
    <a href="login.php">Login</a>
  </div>
  
</div>
<br>
<br>
<br>
<br>
<br>
<br>
<form action="results.php" method="get" autocomplete="on">
<div class="">
   <div class="">
      <input type="text" class=""  name="q" placeholder="What are you looking for?">
      <button type="submit" class=""> Go
        <i class=""></i>
     </button>
   </div>
   <a href="advance.php"><b>Advance_Search</b></a>
   <br>
   <br>
   <a href="index.php">BACK</a>

</div>
</form>

<br>

<br>

 <div class="">
    <div class="" style="">
       <h1>Restaurant Search</h1>
    <h2> Results: </h2>
    <!-- <?php echo $xq; echo nl2br("\r\n");?>
    <?php echo $total; echo nl2br("\r\n"); ?>
    <?php echo $noofpages; ?> -->
    </div>
  </div>
  

<div class="container">
    <div class="row" style="text-align: center">
    <h2> Search Results: </h2>
    </div>
  </div>
  <div id="listId">
    <ul class="list">
      
      <?php
      for ($i=0; $i < $total; $i++) { 
        # code...
        echo "<li class=snippet>";
        
        echo $results[$i]['_source']['name'];
        
        echo "</li>";
      }
      ?>

      
    </ul>
    <ul class="pagination"></ul>
  </div>
  
</body>
</html>