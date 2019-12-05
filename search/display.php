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
  // $web= $results['_source']['websites'];
  // $web = explode(",", $web);

// function exp($text){
//   $text = explode(",",$text);
//   return $text[0];
// }

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
  <!-- <script type="text/javascript" src="hilitor.js"></script> -->
  <script type="text/javascript" src="save.js"></script>
<!--   <script type="text/javascript" src="pagination.js"></script> -->
<style>
        /* Set the size of the div element that contains the map */
        #map {
            height: 400px;
            width: 600px;
        }
    </style>



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
  <a href="index.php">Home</a>
  <a href="#City">City</a>
  <a href="#Venue">Categories</a>
  <a href="#Series">Name</a>  <div class="search-container">
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
<form action="display.php" method="get" autocomplete="on">
  <div class='wrap1'>
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

<br>

<br>

 <div class="">
    <div class="" style="text-align: center">
       <h1>Restaurant Search</h1>

     <?php  echo "Showing results for : ";echo "<strong>".$xq."</strong>"; echo nl2br("\r\n");?>
    <?php echo "total results : ".$total; echo nl2br("\r\n"); ?>
    
    </div>
  </div>
  
<br>

<br>
 <div class="container">
    <div class="row" style="text-align: center">
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
                                echo $name; ?>
                          </a>
                          <!-- <a href="<?php $address= !empty($xq)?highlightWords($results[$i]['_source']['address'],$xq):$results[$i]['_source']['address'];
                                echo $address; ?>" target="_blank"><p><br> 
                            <?php $name= !empty($xq)?highlightWords($results[$i]['_source']['name'],$xq):$results[$i]['_source']['name'];
                                echo $name; ?><p></p><br>
                          </a> -->
                        </div>
                            <b>address:</b>
                                <?php $address= !empty($xq)?highlightWords($results[$i]['_source']['address'],$xq):$results[$i]['_source']['address'];
                                echo $address; ?><br>
                            <b>Categories:</b>
                                <?php $Categories= !empty($xq)?highlightWords($results[$i]['_source']['primaryCategories'],$xq):$results[$i]['_source']['primaryCategories'];
                                echo $Categories; ?><br>
                            <b>Postalcode:</b>
                                <?php $postalCode= !empty($xq)?highlightWords($results[$i]['_source']['postalCode'],$xq):$results[$i]['_source']['postalCode'];
                                echo $postalCode; ?>
                            <br>
<!--                             <div id="map"></div>
    <div id="msg"></div>
    <div id="msg2"></div>
    <script>
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
            const from = { lat: 36.8954387, lng: -76.3058324 };

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
    </script>
    <!--Load the API from the specified URL -- remember to replace YOUR_API_KEY-->
    <!-- <script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD9m50C60wtRqDNa4H3LI7Fmyiaq7NyXa4&callback=initMap">
        </script> --> 
                            <form method="post" action="saves.php">
                              <div class="input-group" style="text-align: center">
                              <button type="submit" class="btn" name="" style="background-color: turquoise; margin-left: 545px;">Save</button>
                              
                            </div>
                            </form>      
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