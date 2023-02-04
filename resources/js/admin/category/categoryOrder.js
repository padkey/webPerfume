//sắp xếp dạnh mục , category order : thứu tự danh mục
$(document).ready(function (){
    $('#categoryOrder').sortable({
            placeholder: 'ui-state-highlight', //class  này là cái hàng tr của dòng di chuyển
        update: function (e,ui){
                var page_id_array = new Array(); // khi mình sắp xếp xong, thì nó sẽ lấy tất cả id trong trang hiện tại theo thứ tự và lưu vào cái mảng này
                var _token = $('input[name="_token"]').val();
            $('#categoryOrder tr').each(function(){ // vào #category xuống dòng tr , ở dòng tr trong thuộc tính id có lưu id của category
                    page_id_array.push($(this).attr('id')); // lấy ra categoryId và nối vào mảng
            });

            $.ajax({
               url:'/shopperfume/arrangeCategory',
                data:{_token:_token,page_id_array:page_id_array},
                method:'POST',
                success:function (data){
                   swal('Good job!','Arrange category successfully!','success');
                }
            });
        }
    })
});
