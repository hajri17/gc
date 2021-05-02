@extends('adminlte::page')

@section('title', 'Transactions')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6 d-flex">
            <h1 class="m-0 text-dark">
                Transactions
            </h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Transactions</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            {{ $dataTable->table() }}
        </div>
    </div>
    <div class="modal fade" id="proof-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered d-flex justify-content-center align-items-center" role="document">
            <div class="inner-modal">
            </div>
        </div>
    </div>
    <div class="modal fade" id="ship-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form class="modal-content" id="ship-form" action="{{ \Session::has('transaction_id') ? route('admin.transactions.ship', \Session::get('transaction_id')) : '' }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="shipping_number">Shipping Number</label>
                        <input class="form-control @error('shipping_number') is-invalid @enderror" id="shipping_number" type="text" name="shipping_number" value="{{ old('shipping_number') }}" required>
                        @error('shipping_number')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary">Confirm</button>
                </div>
            </form>
        </div>
    </div>
@stop

@section('js')
    {{ $dataTable->scripts() }}
    <script>
        $(function () {
            $('#proof-modal').on('show.bs.modal', function (event) {
                let url = $(event.relatedTarget).data('url');
                let img = $(`<img src="/storage/${url}" alt="Proof preview" />`);

                $('#proof-modal .inner-modal').html(img);
            });

            @if(!$errors->has('shipping_number'))
                $('#ship-modal').on('show.bs.modal', function (event) {
                    let action = $(event.relatedTarget).data('action');

                    $('#ship-form').attr('action', action);
                });
            @else
                $('#ship-modal').modal('show');
            @endif
        });
        /*$(document).on('click', '.categories-delete-btn', function () {
            let action = $(this).data('action');
            let form = $('#categories-delete');

            form.attr('action', action)

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
            }).then((result) => {
                if (result.value) {
                    form.submit();
                } else {
                    form.attr('action', '');
                }
            });
        });*/
    </script>
@stop
