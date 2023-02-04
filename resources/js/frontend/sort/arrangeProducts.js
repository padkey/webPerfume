$(document).ready(function(){ //sort và arrange cả hai đều là sắp xếp , sort kiểu phân loại, muốn phân loại theo giá 200-300k , còn arrange thì sắp xếp từ thấp đến cao
    $('#sort').change(function(){
        var url = $(this).val();  //lấy ra giá trị url mình đã xử lý bên view , url hiện tại ?sort=...
            if(url){ //nếu tồn tại url thì
                window.location = url; //cho cái đường dẫn hiện tại thành đường dẫn mình đã xủ lý,
                // rồi ra controller bắt xem có tồn tại sort trên url không
            }
    })

    $('.sort2').click(function(){
      //  var url = $(this).val();  //lấy ra giá trị url mình đã xử lý bên view , url hiện tại ?sort=...
        //lấy category slug
        categorySlug = $('.how-active1').data('category_slug');
        sortBy = $(this).data('sort_by');
        alert(categorySlug);
      //  window.location = '/shopperfume/'+categorySlug

    })

});
