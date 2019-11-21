<?php    
  session_start();
  $db = mysqli_connect('localhost', 'admin', 'monarchs', 'm2');
   require_once 'app/init.php';
    $record_per_page = 10;
    $page = '';
  if(isset($_GET['rest_details'])){

    $data = $_GET['rest_details'];
    $page_num = $data['page_num'];
    $rest_name = $data['rest_name'];
    $from = ($page_num-1) *10;
    
    $query = $es->search([
        'index' => 'final',
        'type' => '_doc',
        'from' => $from,
        'size' => 10,
        'body' => [
          'query' =>[
                     'multi_match' => [ 'query' => $rest_name,
                      'fields' => ['city' ,'name', 'country', 'address','postalCode','province  ']]
              ]

      ]  
    ]);

   if($query['hits']['total'] >= 1){
    $results = $query ['hits']['hits'];

    
        $display="";
    
        foreach($results as $r) {
                $display=$display."<div class='row' style='text-align: center'>";
                $display=$display."<div class='container initial'>";
                $display=$display."<div class='panel panel-success'>";
                $display=$display."<div class=panel-heading style='background-color : aliceblue;''>";
                $display=$display."<h2 class=panel-title>";
                $display=$display."<a href='".$r['_source']['name']."' target='_blank'><p><br>";
                $display=$display."".$r['_source']['name']."";
                $display=$display."</a>";
                $display=$display."</div>";
                $display=$display."<br><br>";
                $display=$display."<b>Movie Director</b><p >";
                $display=$display."".$r['_source']['name']."";
                $display=$display."<p></p><br>";
                $display=$display."<b>Actor</b><p>";
                $display=$display."".$r['_source']['name']."";
                $display=$display."<p></p><br>";
                $display=$display."<b>Genres</b><p> ";
                $display=$display."".$r['_source']['name']."";
                $display=$display."<p></p><br>";
                $display=$display."<b>Rating</b><p>";
                $display=$display."".$r['_source']['name']."";
                $display=$display."<p></p><br>";
                $display=$display."<input method= 'POST' id='".$r['_id']."' type='submit' class='btn btn-success save' value='Save' style='
                background-color: skyblue;'>";
                $display=$display."<br><br>";
                $display=$display."</div>";
                $display=$display."</div>";
                $display=$display."";
                $display=$display."";               
          }
          echo $display;

    }
  

  }
  

  ?>