@extends('layouts.shop')

@push('css')
    <style>
        .btn-review::before {
            display: none;
        }
    </style>
@endpush

@section('content')
    <div class="page-header text-center" style="background-image: url('/molla/assets/images/page-header-bg.jpg')">
        <div class="container">
            <h1 class="page-title">My Checkout<span>Gonicraft</span></h1>
        </div><!-- End .container -->
    </div><!-- End .page-header -->
    <nav aria-label="breadcrumb" class="breadcrumb-nav">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('categories.index') }}">Shop</a></li>
                <li class="breadcrumb-item active" aria-current="page">My Checkout</li>
            </ol>
        </div><!-- End .container -->
    </nav><!-- End .breadcrumb-nav -->

    <div class="page-content">
        <div class="cart">
            <div class="container">
                @error('payment_proof')
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ $message }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @enderror
                @error('review')
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ $message }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @enderror
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                <div class="row">
                    <div class="col-12">
                        @if ($transactions->isNotEmpty())
                            @foreach($transactions as $transaction)
                                <table class="table table-cart table-mobile">
                                    <thead>
                                    <tr>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                     <tr>
                                         <td style="padding-top: 1rem;padding-bottom: 1rem;">
                                             <div>Order Date</div>
                                             <div>Shipping Method</div>
                                         </td>
                                         <td style="padding-top: 1rem;padding-bottom: 1rem;white-space: nowrap">
                                             <div>: {{ $transaction->created_at->isoFormat('LLL') }}</div>
                                             <div>: {{ $transaction->shipping_method->name }}&nbsp;&nbsp; ( Rp{{ number_format($transaction->shipping_method->price_per_kg, 0, ',', '.') }} )</div>
                                         </td>
                                         <td colspan="2" class="text-right" style="padding-top: 2rem;padding-bottom: 2rem;white-space: nowrap">
                                             @if($transaction->is_canceled)
                                                 <div>CANCELED</div>
                                             @elseif($transaction->accepted_at)
                                                 <div>Status: DONE</div>
                                                 <div>Received at: {{ $transaction->accepted_at->isoFormat('LLLL') }}</div>
                                                 @if($transaction->reviews->isEmpty())
                                                    <a href="{{ route('review.create', $transaction->id) }}" class="btn btn-primary mt-1 btn-quickview btn-review" title="Review">Review</a>
                                                 @else
                                                     REVIEWED
                                                 @endif
                                             @elseif($transaction->paid_at && !$transaction->shipped_at)
                                                 <div>PACKED</div>
                                             @elseif($transaction->paid_at && $transaction->shipped_at)
                                                 <div>Status: SHIPPED</div>
                                                 <div>Shipping Number: {{ $transaction->shipping_number }}</div>
                                                 <button data-action="{{ route('transaction.accept', $transaction->id) }}" data-toggle="modal" data-target="#accepted-modal" class="btn btn-primary mt-1 btn-accepted">Package Accepted</button>
                                             @else
                                                 <div>WAITING FOR PAYMENT TO BE CONFIRMED</div>
                                                 <div>
                                                     <button data-action="{{ route('transaction.confirm', $transaction->id) }}" data-toggle="modal" data-target="#confirm-modal" class="btn btn-primary mt-1">Upload payment proof</button>
                                                 </div>
                                             @endif
                                         </td>
                                     </tr>
                                    @foreach($transaction->transaction_details as $transactionDetail)
                                        <tr>
                                            <td class="product-col" style="width: 1%;white-space: nowrap;">
                                                <div class="product">
                                                    <figure class="product-media" style="max-width: 100px;max-height: 100px">
                                                        <a href="#">
                                                            <img style="max-width: 100px;max-height: 100px" src="{{ asset('storage/' . $transactionDetail->item->main_image->url) }}" alt="Product image">
                                                        </a>
                                                    </figure>
                                                </div><!-- End .product -->
                                            </td>
                                            <td style="white-space: nowrap;width: 1%;">
                                                <h3 class="product-title">
                                                    <a href="{{ route('products.show', $transactionDetail->item->id) }}">{{ $transactionDetail->item->name }}</a>
                                                </h3><!-- End .product-title -->
                                                <div>Rp{{ number_format($transactionDetail->item->price, 0, ',', '.') }}</div>
                                                <div><span>x {{ $transactionDetail->qty }}</span></div>
                                            </td>
                                            <td></td>
                                            <td class="total-col">Rp{{ number_format($transactionDetail->qty * $transactionDetail->item->price, 0, ',', '.') }}</td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td colspan="3"></td>
                                        <td class="total-col">
                                            Rp{{ number_format($transaction->transaction_details
                                                    ->sum(function ($td) {
                                                        return $td->item->price * $td->qty;
                                                    }) + $transaction->shipping_method->price_per_kg, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                    </tbody>
                                </table><!-- End .table table-wishlist -->
                            @endforeach
                        @else
                            <div class="d-flex justify-content-center align-items-center flex-column h-100">
                                <h5 class="mb-4 mt-5">No Items in my checkout.</h5>
                                <a href="{{ route('products.index') }}" class="btn btn-primary mb-5">Browse Items</a>
                            </div>
                        @endif

                        {{--<div class="cart-bottom">
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
                        </div><!-- End .cart-bottom -->--}}
                    </div><!-- End .col-12 -->
                </div><!-- End .row -->
            </div><!-- End .container -->
        </div><!-- End .cart -->
    </div><!-- End .page-content -->
@stop

@section('additional')
    <div class="modal fade" id="confirm-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="icon-close"></i></span>
                    </button>

                    <form id="confirm-form" class="form-box" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div>
                            <div class="form-group">
                                <label for="payment_proof">Payment Proof</label>
                                <input type="file" class="form-control" id="proof_image" name="payment_proof" required>
                                <span>Image must be PNG, JPG or JPEG and less than 1MB</span>
                            </div><!-- End .form-group -->
                        </div>
                        <div class="form-choice">
                            <div class="d-flex">
                                <div class="ml-auto">
                                    <button type="submit" class="btn btn-primary">
                                        Confirm
                                    </button>
                                </div><!-- End .col-6 -->
                            </div><!-- End .row -->
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="accepted-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="icon-close"></i></span>
                    </button>

                    <form class="form-box" action="" method="POST">
                        @csrf
                        <h5 class="text-center font-weight-normal">Have you receive your package?</h5>

                        <div class="form-choice mt-3">
                            <div class="d-flex justify-content-center">
                                <div>
                                    <button type="button" data-dismiss="modal" class="btn btn-outline-primary-2">
                                        No
                                    </button>
                                    <button type="submit" class="btn btn-primary">
                                        Yes
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop

@push('js')
    <script>
        $(function () {
            $('#confirm-modal').on('show.bs.modal', function (event) {
                let action = $(event.relatedTarget).data('action');

                $('#confirm-form').attr('action', action);
            });

            $('#confirm-modal').on('hidden.bs.modal', function (event) {
                $('#confirm-form').attr('action', '');
            });

            $('#accepted-modal').on('show.bs.modal', function (event) {
                let action = $(event.relatedTarget).data('action');

                $('#accepted-modal .form-box').attr('action', action);
            });
        });
    </script>
@endpush
