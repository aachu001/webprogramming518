<?php    
  session_start();
  
  $db = mysqli_connect('localhost', 'admin', 'monarchs', 'm2');
  

    $data = $_GET['rest_id'];
    $username =$_SESSION['username'];
         $sql = "DELETE FROM saveitems WHERE id='$data'";
        
         $result = mysqli_query($db, $sql);
        

        // header('refresh:1;url=index1.php');
      

      //echo '<pre>', $total = $query['hits']['total']['value'], '</pre>';
      // $variables['total'] = $total;
        // echo '<pre>', print_r($results), '</pre>';
         //echo '<pre>', print_r($query['hits']['total']['value']), '</pre>';
      
      

?>