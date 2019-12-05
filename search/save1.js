<?php 
  session_start(); 

  if (!isset($_SESSION['username'])) {
    $_SESSION['msg'] = "You must log in first";
    echo $_SESSION['msg'];
    header('location: login.php');
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
$(document).on('click','.save1', function(e){ 

    var id = e.currentTarget.id;
    window.alert("please login");
    $.ajax({
        async:false,
        url:'login.php',
        type: 'get',
        data:{'rest_id':id},
        dataType: 'text',
        success: function(data){

            console.log(data);
        }
    
    
    });


})