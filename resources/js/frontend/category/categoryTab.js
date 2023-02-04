$(document).ready(function (){


    //mặc định cho chạy tab đầu tiên
        var categoryId = $('.categoryTab').data('id');
        var _token = $('input[name="_token"]').val();
        $.ajax({
            url:'/shopperfume/productsByTab',
            method:'POST',
            data:{categoryId:categoryId,_token:_token},
            success:function (data){

                $('#productsByTab').html(data);
            }
        });

    //khi người dùng click vào thì hiển thị
    $('.categoryTab').click(function (){

            /*categoryID2 =$('.how-active1').data('id');
            alert(categoryID2);*/
        var categoryId = $(this).data('id');
        var _token = $('input[name="_token"]').val();
        $.ajax({
            url:'/shopperfume/productsByTab',
            method:'POST',
            data:{categoryId:categoryId,_token:_token},
            success:function (data){
                $('#productsByTab').html(data);

            }
        });

    });

             $(document).on('click','#loadMoreButton',function (){
                var lastProductId = $(this).data('last_product_id');
                var categoryId = $(this).data('category_id');
                 var _token = $('input[name="_token"]').val();
                 $('#loadMoreButton').html("loading . . . ");
                 $.ajax({
                    url:'/shopperfume/loadMoreProducts',
                    method:'POST',
                     data:{categoryId:categoryId,lastProductId:lastProductId,_token:_token},
                     success:function(data){

                            $('#productsByTab').append(data);
                         $('#loadMoreButton').remove();
                     }
                 });
             })



});
