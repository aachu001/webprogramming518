$(document).on('click','.removeitems', function(e){ 
    e.stopImmediatePropagation();
    alert("item removed");
    var id = e.currentTarget.id;
    $.ajax({
        async:false,
        url:'remove.php',
        type: 'get',
        data:{'rest_id':id},
        dataType: 'text',
        success: function(data){

            
            location.reload(true); 
        }
    
    
    });


})