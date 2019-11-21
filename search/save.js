$(document).on('click','.save', function(e){ 

    var id = e.currentTarget.id;
    $.ajax({
        async:false,
        url:'saves.php',
        type: 'get',
        data:{'rest_id':id},
        dataType: 'text',
        success: function(data){

            console.log(data);
        }
    
    
    });


})