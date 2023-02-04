$(document).ready(function (){
   var chart = new Morris.Bar({
        // ID of the element in which to draw the chart.
        element: 'chart',
        // Chart data records -- each entry in this array corresponds to a point on
        // the chart.
       lineColors: ['#819C79', '#fc8710','#FF6541', '#A4ADD3', '#927e33'],
       gridTextColor:'black', // màu cho các giá trị trục
       parseTime:false,
       hideHover:'auto',
        xkey: 'period', // khoảng thời gian , trục tung
        // A list of names of data record attributes that contain y-values.
        ykeys:['total_order','sales','profit','quantity'], //tục hoành , danh sách tên của các thuộc tính bản ghi dữ liệu có chứa giá trị y
        labels: ['total order','sales','profit','quantity'],    // Labels for the ykeys -- will be displayed when you hover over the
    });

     totalProducts =$('.totalProducts').val();
     totalPosts = $('.totalPosts').val();
     totalCustomers = $('.totalCustomers').val();
     totalOrders = $('.totalOrders').val();
    Morris.Donut({
        element: 'donut',
        resize: true,
        colors: [
            '#ce616a',
            '#61a1ce',
            '#ce8f61',
            '#f5b942',
            '#4842f5',
        ],
        //labelColor:"#cccccc", // text color
        //backgroundColor: '#333333', // border color
        data: [
            {label:"Products", value:totalProducts},
            {label:"Posts", value:totalPosts},
            {label:"Orders", value:totalOrders},
            {label:"Customers", value:totalCustomers},

        ]
    });


    $('#btnStatistical').click(function (){
        fromDate = $('.fromDate').val();
        toDate = $('.toDate').val();
        //cắt chuỗi lấy năm tháng ngày thui , không lấy giờ
       fromDate= fromDate.slice(0,10)
       toDate = toDate.slice(0,10);
      var _token = $('input[name="_token"]').val();
      $.ajax({
          url:'/shopperfume/filterByDate',
          method:'POST',
          dataType:'JSON',
          data:{fromDate:fromDate,toDate:toDate,_token:_token},
          success:function (data){
              chart.setData(data);
          }
      })
   }) ;

   //lọc theo lựa chọn
        $('.filterByChoose').change(function(){
            var choose = $(this).val();
            var _token = $('input[name="_token"]').val();
            $.ajax({
               url:'/shopperfume/filterByChoose',
               method:'POST',
               dataType:'JSON',
               data:{choose:choose,_token:_token},
               success:function(data){
                        chart.setData(data);
               }
            });
        });

        function chart3days(){
            var _token = $('input[name="_token"]').val();
            $.ajax({
                url:'/shopperfume/chartDates',
                method:'POST',
                dataType:'JSON',
                data:{_token:_token},
                success:function(data){
                    chart.setData(data);
                }

            })
        }
        chart3days();
});
