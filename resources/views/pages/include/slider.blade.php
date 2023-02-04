<div id="slider-carousel" class="carousel slide" data-ride="carousel">
    <ol class="carousel-indicators">
        <li data-target="#slider-carousel" data-slide-to="0" class="active"></li>
        <li data-target="#slider-carousel" data-slide-to="1"></li>
        <li data-target="#slider-carousel" data-slide-to="2"></li>
    </ol>

    <div class="carousel-inner">
        @php $i=0; @endphp
        @foreach($allSlider as $key => $slider)

            <div class="item {{$i == 0 ?'active' : ''}}">
                <div class="col-sm-12">
                    <video width="100%" height="100%" autoplay muted loop>
                        <source src="{{('public/uploads/sliders/'.$slider->slider_image)}}" type="video/mp4">
                    </video>
                    {{--thẻ alt là để hiển thị mô tả, để google hiểu về cái hình ảnh này để làm j --}}
                    {{--
                                        <img alt="{{$slider->slider_des}}"src="{{('public/uploads/sliders/'.$slider->slider_image)}}"   width="100%" height="300px" class="img img-responsive" />
                    --}}
                </div>
            </div>
            @php $i=1; @endphp
        @endforeach

    </div>

    <a href="#slider-carousel" class="left control-carousel hidden-xs" data-slide="prev">
        <i class="fa fa-angle-left"></i>
    </a>
    <a href="#slider-carousel" class="right control-carousel hidden-xs" data-slide="next">
        <i class="fa fa-angle-right"></i>
    </a>
</div>
