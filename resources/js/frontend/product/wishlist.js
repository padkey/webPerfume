$(document).ready(function (){
    loadWishlist();
    function loadWishlist(){
       //nếu có data , localStorage chit hỗ trợ chuỗi nên ta phải xài JSONparse và JSONstringify
        if(localStorage.getItem('data')!= null){
             var data = JSON.parse(localStorage.getItem('data')); //JSON.parse() là hàm convert chuoix json sang một đối tượng javascript

            data.reverse(); // đảo ngược mảng, phần tử chuối là phần tử đầu
            //trước khi lấy  ra danh sách thì ta phải cho cái cũ thành ''
            $('.row_wishlist').html('');
            for(var i=0;i< data.length;i++){
                $('.row_wishlist').append('<div class="row"><div class="col-md-5" style="margin: 10px 0px">' +
                    '<img width="100%" src="'+data[i].productImage+'"></div>' +
                    '<div class="col-md-7">' +
                    '<p>'+data[i].productName+'</p>'+
                    '<p style="color: #FE980F">'+data[i].productPrice+'</p> <p><a href="'+data[i].productUrl+'" class="btn-xs btn-info">Watch detail</a></p></div></div>');
            }
        }
    }



        $('.addToWishlist').click(function (){
            var productId = $(this).data('id');
            var productName = $('#wishlistProductName-'+productId).val();
            var productImage = $('#wishlistProductImage-'+productId).attr('src');
            var productUrl = $('#wishlistProductUrl-'+productId).attr('href'); //lấy đường dẫn đến productDetail
            var productPrice = $('#wishlistProductPrice-'+productId).text();
            var newItem = { //tạo ra biến mang product mới
                'productUrl' : productUrl,
                'productId':productId,
                'productName':productName,
                'productImage':productImage,
                'productPrice':productPrice,
            }
            //kiểm tra dữ liệu cũ có không, không có thì tạo mới
            if(localStorage.getItem('data') == null){
                localStorage.setItem('data','[]'); //tạp nó bằng rỗng trước
            }
            //lấy ra dữ liệu ,nếu có và không có thì vẫn lấy dữ liệu
            var oldData = JSON.parse(localStorage.getItem('data')); //Json.parse convert một chuổi json sang một đối tượng javascript

            //kiểm tra sản phẩm đã có trong dang sách chưa
            var check = $.grep(oldData,function(data){ // data là từng phần tử oldData[0] ... trong mảng , foreach kiểm tra cũng được
                return data.productId == productId; // trả về phần tử có data.id  = productId
            });
            //nếu trùng
            if(check.length){
                swal('Error!','This product is already on the wishlist!','error')
            }else{

                //nếu chưa có thì đẩy dữ liệu product mới vào oldData
                oldData.push(newItem)
                //hiện thông báo thêm thành công
                swal('Good Job!','Product has been successfully added to the wishlist  !','success')
            }


           // cập nhật lại localStorage , nó lưu giá trị chuỗi chú k có lưu mảng nê ta xài stringify để convert đối tượng js thành chuỗi json
            localStorage.setItem('data',JSON.stringify(oldData)); //JSON.stringify convert đối tượng javascript thành chuỗi json
            loadWishlist(); //load lại cái danh sách để hiện thị cái product mình mới thêm
        });

});
