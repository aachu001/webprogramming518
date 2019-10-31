<?php

  require_once 'app/init.php';

  if(isset($_GET['name']))
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
    $name = xss_clean($_GET['name']);
    $city = xss_clean($_GET['city']);
    $province = xss_clean($_GET['province']);
    $country = xss_clean($_GET['country']);
    $q = $name." ".$city." ".$province." ".$country;

    $query = $es->search([
        'index' => 'final',
        'type' => '_doc',
        'body' => [
        'query' => [
            'bool' => [
                'should' => [
                    
                    [ 'multi_match' => [ 'query' => $q,
                      'fields' => ['city' , 'name', 'province','country']]
                    ],
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
  <link rel="stylesheet" href="styles.css">
  

  

</head>
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
    </div>
  </div>


        <?php
        if(isset($results)) {
            foreach($results as $r) {
            ?>

                <div class="row" style="">
        <div class="">
          <div class="">
                      <div class=panel-heading>
                        <h2 class=panel-title>
                          <a href="index.php" target="_blank"><p><br> 
                            <?php echo $r['_source']['name']; ?>
                          </a>
                          
                      </div>
                        
                          <b>Content:</b><p> 
                              <?php echo $r['_source']['address'] ;
                                echo nl2br("\r\n");
                              echo  $r['_source']['city'];
                              echo nl2br("\r\n");
                              echo  $r['_source']['country'];
                               echo nl2br("\r\n");
                               echo  $r['_source']['categories'];
                               echo nl2br("\r\n");
                               echo  $r['_source']['websites'];
                              ?><p></p>
                      <div class="">
                          <b>DocId:</b>
                            
                                <?php echo $r['_id']; ?>
                            
                          
                    </div> 
                  </div>
                </div>
            <?php
            }
        }
        ?>
</body>
</html>