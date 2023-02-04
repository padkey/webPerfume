//approval :phê duyệt
$(document).ready(function (){
    $('.btnApproval').click(function (){
       var commentId = $(this).data('id');
       var commentStatus = $(this).data('status'); //status ngược để dễ update
        $.ajax({
           url:'/shopperfume/approvalComment',
            method:'POST',
            headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data:{commentId:commentId,commentStatus:commentStatus},
            success:function (data){
               swal('Good job!','Updated status comment successfully','success');
               setTimeout(function(){window.location.reload()},1000);
            }
        });
    });
})
