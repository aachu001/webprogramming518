<?php    
  session_start();
  require_once 'app/init.php';
  $db = mysqli_connect('localhost', 'admin', 'monarchs', 'm2');
  if(isset($_GET['rest_id'])){

    $data = $_GET['rest_id'];
    $username =$_SESSION['username'];
    
    $query = $es->search([
        'index' => 'final',
        'type' => '_doc',
        'body' => [
          'query' =>[
                     'multi_match' => [ 'query' => $data,
                      'fields' => ['id']]
              ]

      ]  
    ]);
    

      if($query['hits']['total'] >= 1){
         $results = $query['hits']['hits'];
       
         foreach($results as $r) {

            $rest_name=$r['_source']['name'];
            $rest_categories=$r['_source']['categories'];
            $rest_address=$r['_source']['address'];
            $rest_websites=$r['_source']['websites'];
         }
      
       
         $sql = "INSERT INTO saveitems (`user`, `id`, `name`, `categories`, `address`,`websites`) VALUES ('$username','$data', '$rest_name', '$rest_categories', '$rest_address','$rest_websites')";
        
         $result = mysqli_query($db, $sql);
         echo "inserted";

      //echo '<pre>', $total = $query['hits']['total']['value'], '</pre>';
      // $variables['total'] = $total;
        // echo '<pre>', print_r($results), '</pre>';
         //echo '<pre>', print_r($query['hits']['total']['value']), '</pre>';
      }
      
}
?>