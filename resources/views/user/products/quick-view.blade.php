<div class="container quickView-container">
    <div class="quickView-content">
        <div class="row">
            <div class="col-lg-7 col-md-6">
                <div class="row">
                    <div class="product-left">
                        @foreach([$product->main_image, ...$product->images] as $image)
                            <a href="#{{ $image->id }}" class="carousel-dot {{ $loop->first ? 'active' : '' }}">
                                <img src="{{ asset('storage/'.$image->url) }}">
                            </a>
                        @endforeach
                    </div>
                    <div class="product-right">
                        <div class="owl-carousel owl-theme owl-nav-inside owl-light mb-0" data-toggle="owl" data-owl-options='{
	                        "dots": false,
	                        "nav": false,
	                        "URLhashListener": true,
	                        "responsive": {
	                            "900": {
	                                "nav": true,
	                                "dots": true
	                            }
	                        }
	                    }'>
                            @foreach([$product->main_image, ...$product->images] as $image)
                                <div class="intro-slide" data-hash="{{ $image->id }}">
                                    <img src="{{ asset('storage/'.$image->url) }}" alt="Image Desc">
                                    <a href="{{ route('products.fullscreen', $product->id) }}" class="btn-fullscreen">
                                        <i class="icon-arrows"></i>
                                    </a>
                                </div><!-- End .intro-slide -->
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-5 col-md-6">
                <h2 class="product-title">{{ $product->name }}</h2>
                <h3 class="product-price">Rp{{ number_format($product->price, 0, ',', '.') }}</h3>

                <div class="ratings-container">
                    <div class="ratings">
                        <div class="ratings-val" style="width: 20%;"></div><!-- End .ratings-val -->
                    </div><!-- End .ratings -->
                    <span class="ratings-text">( {{ $product->reviews->count() }} Reviews )</span>
                </div><!-- End .rating-container -->

                <p class="product-txt">{{ $product->description }}</p>

                <div class="details-filter-row details-row-size">
                    <label for="qty">Qty:</label>
                    <div class="product-details-quantity">
                        <input type="number" id="qty" class="form-control" value="1" min="1" max="10" step="1" data-decimals="0" required>
                    </div><!-- End .product-details-quantity -->
                </div><!-- End .details-filter-row -->

                <div class="product-details-action">
                    {{--<div class="details-action-wrapper">
                    </div><!-- End .details-action-wrapper -->--}}
                    <a href="#" data-item_id="{{ $product->id }}" class="btn-product btn-cart"><span>add to cart</span></a>
                </div>

                <div class="product-details-footer">
                    <div class="product-cat">
                        <span>Category:</span>
                        <a href="#">{{ $product->category->name }}</a>
                    </div><!-- End .product-cat -->

                    <div class="social-icons social-icons-sm">
                        <span class="social-label">Share:</span>
                        <a href="#" class="social-icon" title="Facebook" target="_blank"><i class="icon-facebook-f"></i></a>
                        <a href="#" class="social-icon" title="Twitter" target="_blank"><i class="icon-twitter"></i></a>
                        <a href="#" class="social-icon" title="Instagram" target="_blank"><i class="icon-instagram"></i></a>
                        <a href="#" class="social-icon" title="Pinterest" target="_blank"><i class="icon-pinterest"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
