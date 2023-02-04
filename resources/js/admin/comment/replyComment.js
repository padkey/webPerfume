//approval :phê duyệt
$(document).ready(function (){
    $('.btnReplyComment').click(function (){
        var commentId = $(this).data('comment_id');
        var productId = $(this).data('product_id'); //status ngược để dễ update
        var replyContent = $('.replyContent-'+commentId).val();

        $.ajax({
            url:  '/shopperfume/replyComment',
            method:'POST',
            headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data:{commentId:commentId,productId:productId,replyContent:replyContent},
            success:function (data){
                swal('Good job!','Reply comment successfully.','success');
                setTimeout(function(){window.location.reload()},1000);
            }
        });
    });
})
