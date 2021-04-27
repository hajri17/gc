@extends('layouts.shop')

@section('content')
    <div class="page-header text-center" style="background-image: url('/molla/assets/images/page-header-bg.jpg')">
        <div class="container">
            <h1 class="page-title">Pending Transaction<span>Gonicraft</span></h1>
        </div><!-- End .container -->
    </div><!-- End .page-header -->
    <nav aria-label="breadcrumb" class="breadcrumb-nav">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('categories.index') }}">Shop</a></li>
                <li class="breadcrumb-item active" aria-current="page">Pending Checkout</li>
            </ol>
        </div><!-- End .container -->
    </nav><!-- End .breadcrumb-nav -->

    <div class="page-content">
        <div class="cart">
            <div class="container">
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
                            @foreach($transaction->transaction_details as $cart)
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
                                    <td class="remove-col"><button class="btn-remove"><i class="icon-close"></i></button></td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table><!-- End .table table-wishlist -->
                    </div><!-- End .col-lg-9 -->
                    <aside class="col-lg-3">
                        <div class="summary summary-cart">
                            <h3 class="summary-title">Transaction Details</h3><!-- End .summary-title -->

                            <table class="table table-summary">
                                <tbody>
                                <tr>
                                    <td>Status:</td>
                                    @if(!$transaction->paid_at && !$transaction->is_canceled)
                                        <td>Waiting for payment to be confirmed</td>
                                    @endif

                                    @if(!$transaction->paid_at && $transaction->is_canceled)
                                        <td>Transaction is canceled</td>
                                    @endif

                                    @if($transaction->paid_at)
                                        <td>Transaction is success</td>
                                    @endif
                                </tr>
                                <tr class="summary-subtotal">
                                    <td>Subtotal:</td>
                                    <td>Rp{{
                                        number_format($total, 0, ',', '.')
                                    }}</td>
                                </tr><!-- End .summary-subtotal -->
                                <tr class="summary-shipping">
                                    <td>Shipping:</td>
                                    <td>{{ $transaction->shipping }}</td>
                                </tr>

                                <tr class="summary-total">
                                    <td>Total:</td>
                                    <td id="cart-total">Rp{{ number_format($total + $shippingCost, 0, ',', '.') }}</td>
                                </tr><!-- End .summary-total -->
                                </tbody>
                            </table><!-- End .table table-summary -->

                        </div><!-- End .summary -->

                        <a href="{{ route('products.index') }}" class="btn btn-outline-dark-2 btn-block mb-3"><span>CONTINUE SHOPPING</span><i class="icon-refresh"></i></a>
                    </aside><!-- End .col-lg-3 -->
                </div><!-- End .row -->
            </div><!-- End .container -->
        </div><!-- End .cart -->
    </div><!-- End .page-content -->
@stop
