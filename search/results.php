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

  <script type="text/javascript" src="hilitor.js"></script>
  <script type="text/javascript" src="save.js"></script>
  <script type="text/javascript" src="pagination.js"></script>


 <style>
        /* Set the size of the div element that contains the map */
        #map {
            height: 400px;
            width: 600px;
        }
    </style>


</head>
<script type="text/javascript">

  var myHilitor; // global variable
  window.addEventListener("DOMContentLoaded", function(e) {
    myHilitor = new Hilitor("content");
    myHilitor.apply("<?php echo $xq; ?>");
  }, false);

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
  <div class="page"></div>
  
  
        <?php
        if(isset($results)) {
         $max = sizeof($results);
         $pagesize =10;
         $pagecount = $max/$pagesize;
         echo "Maximum : ",$max,"\r\n";
         echo "Pagesize : ",$pagesize,"\r\n";
         echo "PageCount : ",$pagecount,"\r\n";

            foreach($results as $key=>$r) {
              $i=1;

             if($key<$pagesize)
             {

             
            ?>
            
              
                <div class="row" style="text-align: center">
           <div class="container initial">
          <div class="panel panel-success">
                      <div class0=panel-heading>
                        <h2 class=panel-title>
                          <a href="<?php echo $r['_source']['websites']; ?>" target="_blank"><p><br> 
                            <?php echo $r['_source']['name']; ?>
                          </a>
                          
                      </div>
                        
                          <b>Content:</b><p> 
                                <?php echo $r['_source']['name'];
                                echo nl2br("\r\n"); ?>

                              <?php echo $r['_source']['address'] ;
                                echo nl2br("\r\n");
                              echo  $r['_source']['city'];
                              echo nl2br("\r\n");
                              echo  $r['_source']['country'];
                               echo nl2br("\r\n");
                               echo  $r['_source']['categories'];
                               echo nl2br("\r\n");
                               // echo  $r['_source']['websites'];
                              ?><p></p>
                      <div class="">
                          <b>DocId:</b>
                            
                                <?php echo $r['_id']; ?>
                    </div>
                    <div id="showmap">
                       <input id="<?php echo $r['_source']['id']; ?>" method="POST" type="submit" class="btn btn-success showmap" value="Map">
                       
                    </div>
                    <div id="map"></div>

                    
    

   

                    <input method= "POST" id="<?php echo $r['_id']; ?>" type="submit" class="btn btn-success saves" value="Save" style="
    background-color: skyblue;">
                     <br>

               <br>dd

                  </div>
                  
                </div>
               
                
            <?php
             }

             $i++;
            } 
            
            ?>
            </div>
            <?php          
            for($i=1;$i<$pagecount;$i++){
            ?>

               <a class="page-link searchresult" id="<?php echo $xq ?>" href="#" value=<?php echo $i?>><?php echo $i ?></a>
            <?php       
            }
          

          
            ?>
  

               
          
           
                
               
           
          
            <?php
        }
        ?>
    <!--     <script>
        // Initialize and add the map


        var map;
        function haversine_distance(mk1, mk2) {
            var R = 3958.8; // Radius of the Earth in miles
            var rlat1 = mk1.position.lat() * (Math.PI / 180); // Convert degrees to radians
            var rlat2 = mk2.position.lat() * (Math.PI / 180); // Convert degrees to radians
            var difflat = rlat2 - rlat1; // Radian difference (latitudes)
            var difflon = (mk2.position.lng() - mk1.position.lng()) * (Math.PI / 180); // Radian difference (longitudes)

            var d = 2 * R * Math.asin(Math.sqrt(Math.sin(difflat / 2) * Math.sin(difflat / 2) + Math.cos(rlat1) * Math.cos(rlat2) * Math.sin(difflon / 2) * Math.sin(difflon / 2)));
            return d;
        }
        function initMap() {
            // The map, centered on Central Park
            const center = { lat: 36.8954387, lng: -76.3058324 };
            const options = { zoom: 10, scaleControl: true, center: center };
            map = new google.maps.Map(
                document.getElementById('map'), options);
            // Locations of landmarks

            const to = { lat: 36.7953409, lng: -76.2928175 };
       

            // The markers for The Dakota and The Frick Collection
            var mk1 = new google.maps.Marker({ position: to, map: map });
            var mk2 = new google.maps.Marker({ position: from, map: map });

            var line = new google.maps.Polyline({ path: [to, from], map: map });
            var distance = haversine_distance(mk1, mk2);
            document.getElementById('msg').innerHTML = "Distance between markers: " + distance.toFixed(2) + " mi.";
            var address = 'Norfolk';
            var geo = new google.maps.Geocoder;
            geo.geocode({ 'address': address }, function (results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    var myLatLng = results[0].geometry.location;

                    var long = document.getElementById('msg2'), myLatLng;

                } else {
                    alert("Geocode was not successful for the following reason: " + status);
                }
            });
        }
    </script> -->
    <!--Load the API from the specified URL -- remember to replace YOUR_API_KEY-->
    <script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD9m50C60wtRqDNa4H3LI7Fmyiaq7NyXa4&callback=initMap">
        </script>
</body>
</html>