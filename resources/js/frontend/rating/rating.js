$(document).ready(function (){
    //khi hover lên thì đổi sao thành màu xám để tăng màu theo khi người dùng rê chuột
    function removeBackgound(productId){
          for(var i =1 ; i<=5 ; i++){
              $('#'+productId+'-'+i).css('color','#ccc');
              //alert(productId)
          }
    }
    //hover chuột lên sao
    $('.rating').mouseenter(function (){
        var index = $(this).data('index'); //index là số sao mình đánh giá
        var productId = $(this).data('product_id');
        removeBackgound(productId); // đổi thành sao màu xám hết
        //tăng sao khi người dùng hover lên, cho bằng index là tăng sao theo cái rê chuột hiện tại,
        // nếu để là số 5 thì hover lên bất kì nó tăng ào tới sao số 5 luôn
        for(var i = 0 ; i <= index ; i++){
            $('#'+productId+'-'+i).css('color','#ffcc00')
        }
    });

    //khi rê vào mà không đánh giá thì cho nó về lại sao ban đầu
    $('.rating').mouseleave(function(){
        var rating = $(this).data('rating'); // giá trị mặc định
        var productId = $(this).data('product_id');
        //trước khi đặt phải cho sao về màu xám, vì lỡ người dùng hover lên 5 sao mà sao mặc định là 4 thì tăng sao sai
        removeBackgound(productId);
        //tăng sao lại mặc định
        for(var i=0;i<=rating;i++){
            $('#'+productId+'-'+i).css('color','#ffcc00');
        }
    })
    //khi người dùng click đánh giá
    $('.rating').click(function(){
        var productId = $(this).data('product_id');
        var index = $(this).data('index'); // index là số sao mà mình đánh gía
        var _token = $('input[name="_token"]').val();
        $.ajax({
           url:'/shopperfume/insertRating',
            method:'POST',
            data:{productId:productId,index:index,_token:_token},
            success:function (data){
               swal('Good job!','You have rated '+index+' stars !','success');
               setTimeout(function (){window.location.reload()},1500)
            }
        });
    });

});
