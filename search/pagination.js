$(document).on('click','.searchresult', function(e){ 

    var page=$(this).text();
    var name = e.currentTarget.id;
    
    $.ajax({
        async:false,
        url:'pagination.php',
        type: 'get',
        data:{ 'rest_details':{'page_num':page, 'rest_name':name}},
        dataType: 'text',
        success: function(data){

            $('.initial').hide();
            $(".page").html(data);
        }
    
    
    });


})


// $(document).on('click','.searchresult1', function(e){ 

//     var page=$(this).text();
//     var title = e.currentTarget.id;
    
//     $.ajax({
//         async:false,
//         url:'pagination.php',
//         type: 'get',
//         data:{ 'rest_details':{'page_num':page, 'rest_name':title}},
//         dataType: 'text',
//         success: function(data){

//             $('.initial').hide();
//             $(".page").html(data);
//         }
    
    
//     });


// })