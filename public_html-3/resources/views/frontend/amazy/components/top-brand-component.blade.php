<!-- 0001-add -->
@push('styles')

    <style>
        .slick-track{
            position: relative;
            top: 0;
            left: 0;
            display: flex;
            align-items: center;
        }
    </style>
    
@endpush
<!-- End 0001-add -->

<div id="top_brands" class="amaz_brand">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section__title d-flex align-items-center gap-3 mb_30">
                    <h3 id="top_brands_title" class="m-0 flex-fill">{{$top_brands->title}}</h3>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <!-- 0002-comment -->
                <!--<div class="amazBrand_boxes">
                    @foreach($top_brands->getBrandByQuery() as $key => $brand)
                        <a href="{{route('frontend.category-product',['slug' => $brand->slug, 'item' =>'brand'])}}" class="single_brand d-flex align-items-center justify-content-center">
                            <img data-src="{{ showImage($brand->logo?$brand->logo:'frontend/default/img/brand_image.png') }}" src="{{showImage(themeDefaultImg())}}" class="lazyload" alt="{{$brand->name}}" title="{{$brand->name}}">
                        </a>
                    @endforeach
                </div>-->
                <!-- End 0002-comment -->
                
                <!-- 0002-add -->
                <div class="slider-brand">
                    @foreach($top_brands->getBrandByQueryForSlider() as $key => $brand)
                        <a href="{{route('frontend.category-product',['slug' => $brand->slug, 'item' =>'brand'])}}" class="single_brand d-flex align-items-center justify-content-center">
                            <img data-src="{{ showImage($brand->logo?$brand->logo:'frontend/default/img/brand_image.png') }}" src="{{showImage(themeDefaultImg())}}" width="60%" class="lazyload" alt="{{$brand->name}}" title="{{$brand->name}}">
                        </a>
                    @endforeach
                </div>
                <!-- End 0002-add -->
                
            </div>
        </div>
    </div>
</div>

<!-- 0003-add -->
@push('scripts')
    <script>

        (function($){
            "use strict";
            $(document).ready(function(){
                
                $('.slider-brand').slick({
                    dots: false,
                    arrows: false,
                    autoplay: true,
                    autoplaySpeed: 2000,
                    speed: 500,
                    slidesToShow: 6,
                    responsive: [{
                        breakpoint: 800,
                        settings: {
                            slidesToShow: 4,
                        }
                    },
                    {
                        breakpoint: 600,
                        settings: {
                            slidesToShow: 2,
                        }
                    }]
                });
            });
        })(jQuery);
    </script>
@endpush
<!-- End 0003-add -->
