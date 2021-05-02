@extends('layouts.shop')

@section('content')
    <div class="page-header text-center" style="background-image: url('/molla/assets/images/page-header-bg.jpg')">
        <div class="container">
            <h1 class="page-title">Shopping Cart<span>Gonicraft</span></h1>
        </div><!-- End .container -->
    </div><!-- End .page-header -->
    <nav aria-label="breadcrumb" class="breadcrumb-nav">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('categories.index') }}">Shop</a></li>
                <li class="breadcrumb-item active" aria-current="page">Shopping Cart</li>
            </ol>
        </div><!-- End .container -->
    </nav><!-- End .breadcrumb-nav -->

    <div class="page-content">
        <div class="cart">
            <div class="container">
                @if ($carts->isNotEmpty())
                    <div class="row">
                        <div class="col-lg-9">
                            <table class="table table-cart table-mobile">
                                <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                    <th></th>
                                </tr>
                                </thead>

                                <tbody>
                                @foreach($carts as $cart)
                                    <tr>
                                        <td class="product-col">
                                            <div class="product">
                                                <figure class="product-media">
                                                    <a href="#">
                                                        <img src="{{ asset('storage/' . $cart->item->main_image->url) }}" alt="Product image">
                                                    </a>
                                                </figure>

                                                <h3 class="product-title">
                                                    <a href="#">{{ $cart->item->name }}</a>
                                                </h3><!-- End .product-title -->
                                            </div><!-- End .product -->
                                        </td>
                                        <td class="price-col">Rp{{ number_format($cart->item->price, 0, ',', '.') }}</td>
                                        <td class="quantity-col">
                                            <div class="cart-product-quantity">
                                                <input type="number" class="form-control" value="{{ $cart->qty }}" min="1" max="10" step="1" data-decimals="0" required>
                                            </div><!-- End .cart-product-quantity -->
                                        </td>
                                        <td class="total-col">Rp{{ number_format($cart->qty * $cart->item->price, 0, ',', '.') }}</td>
                                        <td class="remove-col">
                                            <form action="{{ route('carts.destroy', $cart->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                            <button class="btn-cart-remove-cart"><i class="icon-close"></i></button>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table><!-- End .table table-wishlist -->

                            <div class="cart-bottom">
                                <div class="cart-discount">
                                    <form action="#">
                                        <div class="input-group">
                                            <input type="text" class="form-control" required placeholder="coupon code">
                                            <div class="input-group-append">
                                                <button class="btn btn-outline-primary-2" type="submit"><i class="icon-long-arrow-right"></i></button>
                                            </div><!-- .End .input-group-append -->
                                        </div><!-- End .input-group -->
                                    </form>
                                </div><!-- End .cart-discount -->

                                <a href="#" class="btn btn-outline-dark-2"><span>UPDATE CART</span><i class="icon-refresh"></i></a>
                            </div><!-- End .cart-bottom -->
                        </div><!-- End .col-lg-9 -->
                        <aside class="col-lg-3">
                            <div class="summary summary-cart">
                                <h3 class="summary-title">Cart Total</h3><!-- End .summary-title -->

                                <table class="table table-summary">
                                    <tbody>
                                    <tr class="summary-subtotal">
                                        <td>Subtotal:</td>
                                        <td>Rp{{
                                            number_format($cartTotal, 0, ',', '.')
                                        }}</td>
                                    </tr><!-- End .summary-subtotal -->
                                    <tr class="summary-shipping">
                                        <td>Shipping:</td>
                                        <td>&nbsp;</td>
                                    </tr>

                                    @foreach($shippingMethods as $shipping)
                                        <tr class="summary-shipping-row">
                                            <td>
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" id="{{ \Illuminate\Support\Str::slug($shipping->name) }}" name="shipping_method_id" value="{{ $shipping->price_per_kg }}" class="custom-control-input" required>
                                                    <label class="custom-control-label" for="{{ \Illuminate\Support\Str::slug($shipping->name) }}">{{ $shipping->name }}</label>
                                                </div><!-- End .custom-control -->
                                            </td>
                                            <td>Rp{{ number_format($shipping->price_per_kg, 0, ',', '.') }}</td>
                                        </tr><!-- End .summary-shipping-row -->
                                    @endforeach

                                    {{--<tr class="summary-shipping-estimate">
                                        <td>Estimate for Your Country<br> <a href="dashboard.html">Change address</a></td>
                                        <td>&nbsp;</td>
                                    </tr><!-- End .summary-shipping-estimate -->--}}

                                    <tr class="summary-total">
                                        <td>Total:</td>
                                        <td id="cart-total">Rp{{ number_format($cartTotal, 0, ',', '.') }}</td>
                                    </tr><!-- End .summary-total -->
                                    </tbody>
                                </table><!-- End .table table-summary -->

                                <a href="#" class="btn btn-outline-primary-2 btn-order btn-block">PROCEED TO CHECKOUT</a>
                            </div><!-- End .summary -->

                            <a href="category.html" class="btn btn-outline-dark-2 btn-block mb-3"><span>CONTINUE SHOPPING</span><i class="icon-refresh"></i></a>
                        </aside><!-- End .col-lg-3 -->
                    </div><!-- End .row -->
                @else
                    <div class="d-flex justify-content-center align-items-center flex-column h-100">
                        <h5 class="mb-4 mt-5">No Items in the cart.</h5>
                        <a href="{{ route('products.index') }}" class="btn btn-primary mb-5">Browse Items</a>
                    </div>
                @endif
            </div><!-- End .container -->
        </div><!-- End .cart -->
    </div><!-- End .page-content -->
@stop

@section('additional')
    <form id="checkout-form" action="{{ route('checkout.create') }}" method="GET">
        @csrf
        <input type="hidden" name="shipping-option">
    </form>
@endsection

@push('js')
    <script>
        $('input[name="shipping_method_id"]').on('change', function () {
            let valId = $(this).attr('id');

            $('input[name="shipping-option"]').val(valId);
        });

        $('.btn-order').on('click', function () {
            $('#checkout-form').submit();
        });
    </script>
@endpush
